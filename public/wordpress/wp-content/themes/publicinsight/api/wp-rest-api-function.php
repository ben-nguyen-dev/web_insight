<?php

class ApiDefaultController extends ApiBaseController
{
    public $method;
    public $response;

    public function __construct($method)
    {
        $this->method = $method;
        $this->response = array(
            'status' => false,
            'error' => null
        );
    }

    public function init(WP_REST_Request $request)
    {
        try {
            if (!method_exists($this, $this->method)) {
                throw new Exception('No method exists', 500);
            }
            $data = $this->{$this->method}($request);
            $this->response = $data;
        } catch (Exception $e) {
            $this->response['status'] = false;
            $this->response['error'] = $e->getMessage();
        }

        return $this->response;
    }
    
    public function list ($request) {
        $user = wp_get_current_user();
        // $user_id = 1;
        if(!$user || $user->ID == 0) {
            return ["status" => false, "error" => "You must login to get posts."];
        }
        $user_id = $user->ID;
        $pageSize = 10;
        $pageNumber = $request['page'];
        $type = $request['type'];
        $state = $request['state'];
        $args = array( 'post_type' =>  'post', 
            'posts_per_page' => $pageSize,
			'author' => '' . $user_id,
            'post_status' => array('draft', 'publish'),
            'orderby' => 'post_date',
			'order' => 'DESC', 
            'paged' => $pageNumber);
        $meta_query = array();
        if($type) {
            $query = array(
                'key'   => 'post_type',
                'value' => $type,
            );
            array_push($meta_query, $query);
        }
        if($state) {
            $query = array(
                'key'   => 'post_state',
                'value' => $state,
            );
            array_push($meta_query, $query);
        }
        $args['meta_query'] = $meta_query;
        $data = array();
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $post_id = $post->ID;
            $post->url = get_permalink($post_id);
            $post->type = strtolower(get_post_meta($post_id, 'post_type', true));
            $post->state = strtolower(get_post_meta($post_id, 'post_state', true)); 
            $post->tags = get_the_tags($post_id);
            $post->authors = get_field('authors',$post_id);
            $post->thumbnailUrl = get_the_post_thumbnail_url($post_id, 'pi-small-thumbnail');
            array_push($data, $post);
        }
        $total = count_user_posts($user_id);
        $user_roles = (array) $user->roles;
        if(in_array("contributor", $user_roles)) {
            $allowCreatePost = true;
        }
        return ["status" => true, "posts" => ["data" => $data, "current_page" => $pageNumber, "per_page" => $pageSize, "total" => $total, "allowCreatePost" => $allowCreatePost ?? false]];
    }

    public function show ($request) {
        $user = wp_get_current_user();
        if(!$user || $user->ID == 0) {
            return ["status" => false, "error" => "You must login to get posts."];
        } 
        $post_id = $request['id'];
        $post = get_post($post_id);
        $acceptTerm = get_post_meta($post_id, 'accept_term', true);
        if($post) {
            $post->url = get_permalink($post_id);
            $post->type = strtolower(get_post_meta($post_id, 'post_type', true));
            $post->state = strtolower(get_post_meta($post_id, 'post_state', true));
            $post->tags = get_the_tags($post_id);
            $post->authors = get_field('authors',$post_id);
            $post->thumbnailUrl = get_the_post_thumbnail_url($post_id, 'pi-large-thumbnail');
            $post->acceptTerm = $acceptTerm == 'true' || $acceptTerm == '1' ? true : false; 
            return ["status" => true, "post" => $post];
        }
        return ["status" => false, "error" => "Can not get post."];
    }

    public function getTags ($request) {
        $pageSize = 10;
        $page = isset($request["page"]) && (int)$request["page"] > 0 ? (int)$request["page"] : 1;
        // $tagName = isset($request["tagName"]) ? $request["tagName"] : null;
        $tags = get_tags();
        return ["status" => true, "data" => $tags, "current_page" => $page, "per_page" => $pageSize, "total" => count($tags)];
    }

    public function getAuthors ($request) {
        $pageSize = 10;
        $page = isset($request["page"]) && (int)$request["page"] > 0 ? (int)$request["page"] : 1;
       
        $authors = get_users( array(
            'role__in'     => array('author'),
        ) );
        $data = array();
        foreach ($authors as $author) {
            $item = [
                "name" => $author->display_name
            ];
            array_push($data, $item);
        }
        return ["status" => true, "data" => $data, "current_page" => $page, "per_page" => $pageSize, "total" => count($authors)];
    }

    public function save ($request) {
        $user = wp_get_current_user();
        if(!$user || $user->ID == 0) {
            return ["status" => false, "error" => "You must login to save post."];
        } 
        // $user = get_user_by('ID', 1);
        $validationRule = [
            "actionType" => "required|max:255"
        ];

        $params = $request->get_params();
        if($_FILES) {
            $params['mainImage'] = $_FILES['mainImage'];
        }
       
        if (array_key_exists("actionType", $params)) {
            $actionType = $params["actionType"];

            if ($actionType !== "draft") {
                array_merge($validationRule, [
                    // "_id" => "required",
                    "headline" => "required|max:255",
                    "preamble" => "required",
                    "body" => "required"
                ]);
            }
        }

        $validator = validate($params, $validationRule);
        if(!empty($validator)) {
            return ["status" => false, "error" => $validator];
        }
        try {
            if (array_key_exists("_id", $params)) {
                return $this->updatePost($params, $user);
            } else {
                return $this->createPost($params, $user);
            }
        } catch (\Exception $e) {
            return ["status" => false, "error" => $e->getMessage()];
        }
    }

    public function updatePost ($post, $user) {
        $tags = null;

        if (isset($post["tags"])) {
            $tags = $post["tags"];
            if ($tags) {
                if (is_string($tags)) {
                    $tags = explode(",", $tags);
                }
            }
        }
        $authorReferences = null;

        if (isset($post["authors"])) {
            $authors = $post["authors"];
            if (is_string($authors)) {
                $authors = explode(",", $authors);
            }
            if (is_array($authors)) {
                $authorReferences = $this->getAuthorReferences($authors);
            }
        }
        $post_id = $post["_id"];
        $doc = [
            "ID" => $post_id,
            "post_type" => "post",
            "post_title" => isset($post["headline"]) ? trim($post["headline"]) : '',
            "post_excerpt" => isset($post["preamble"]) ? trim($post["preamble"]) : '',
            "post_content" => isset($post["body"]) ? $post["body"] : '',
            "post_author" => "" . $user->ID,
        ];
        $state = isset($post["actionType"]) ? $this->getPostStateByAction($post["actionType"]) : 'draft';

        $image_url = '';
        if(array_key_exists("mainImage", $post)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $overrides = array(
                'test_form' => false,
                'test_size' => true,
            );
            $results = wp_handle_sideload( $post["mainImage"], $overrides );
            if ( !empty( $results['error'] ) ) {
                return ["status" => false, "error" => "Can not upload main image for post"];
            } 
            $image_url = $results['url'];
        }

        $check = wp_update_post($doc);
        if(is_wp_error($check)) {
            return ["status" => false, "error" => "Can not update post id: " . $post_id];
        }
        if($image_url) {
            generate_featured_image( $image_url, $post_id );
        }
        wp_set_post_tags($post_id, $tags);
        update_field('post_state', $state, $post_id);
        update_field('authors', $authorReferences, $post_id);
        update_field('accept_term', $post["acceptTerm"] == "true" ? true : false, $post_id);
        return ["status" => true, "post" => get_post($post_id)];
    }

    function getPostStateByAction($actionType) {
        if ($actionType == "submit") {
            return "submitted";
        } else {
            return "draft";
        }
    }

    public function createPost ($post, $user) {

        $tags = null;

        if (isset($post["tags"])) {
            $tags = $post["tags"];
            if ($tags) {
                if (is_string($tags)) {
                    $tags = explode(",", $tags);
                }
            }
        }
        $authorReferences = null;

        if (isset($post["authors"])) {
            $authors = $post["authors"];
            if (is_string($authors)) {
                $authors = explode(",", $authors);
            }
            if (is_array($authors)) {
                $authorReferences = $this->getAuthorReferences($authors);
            }
        }
        $doc = [
            "post_type" => "post",
            "post_title" => isset($post["headline"]) ? trim($post["headline"]) : '',
            "post_excerpt" => isset($post["preamble"]) ? trim($post["preamble"]) : '',
            "post_content" => isset($post["body"]) ? $post["body"] : '',
            "post_author" => "" . $user->ID,
        ];
        $state = isset($post["actionType"]) ? $this->getPostStateByAction($post["actionType"]) : 'draft';

        $image_url = '';
        if(array_key_exists("mainImage", $post)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $overrides = array(
                'test_form' => false,
                'test_size' => true,
            );
            $results = wp_handle_sideload( $post["mainImage"], $overrides );
            if ( !empty( $results['error'] ) ) {
                return ["status" => false, "error" => "Can not upload main image for post"];
            } 
            $image_url = $results['url'];
        }

        $post_id = wp_insert_post($doc);
        if($post_id) {
            if($image_url) {
                generate_featured_image( $image_url, $post_id );
            }
            wp_set_post_tags($post_id, $tags);
            update_field('post_type', "comment", $post_id);
            update_field('post_state', $state, $post_id);
            update_field('authors', $authorReferences, $post_id);
            update_field('accept_term', $post["acceptTerm"] == "true" ? true : false, $post_id);
            return ["status" => true, "post" => get_post($post_id)];
        }
        return ["status" => false, "error" => "Can not create post"];
    }
    
    function getTagReferences($tags)
    {
        $tagsReferences = [];

        foreach ($tags as $tag) {
            $term = get_term_by('name', $tag, 'post_tag');
            if(!empty($term)) {
                array_push($tagsReferences, $term);
            } else {
                $term = wp_insert_term( $tag, 'post_tag' );
                array_push($tagsReferences, $term);
            }
        }

        return $tagsReferences;
    }

    function getAuthorReferences($authors)
    {
        $authorReferences = [];

        foreach ($authors as $author) {
            if(!empty($author)) {
                $users = new WP_User_Query( array(
                    'search'         => trim($author),
                    'search_columns' => array(
                        'user_nicename',
                        'display_name',
                    ),
                ) );
                $user = $users->get_results();
                if($user) {
                    array_push($authorReferences, $user[0]);
                }
            }
        }
        return $authorReferences;
    }

    public function delete ($request) {
        $user = wp_get_current_user();
        if(!$user || $user->ID == 0) {
            return ["status" => false, "error" => "You must login to delete post."];
        } 
        $validationRule = [
            "id" => "required"
        ];
        $validator = validate($request->get_params(), $validationRule);
        if(!empty($validator)) {
            return ["status" => false, "error" => $validator];
        }
        $post_id = $request['id'];
        $post = get_post($post_id);
        if($post) {
            wp_delete_post($post_id);
            return ["status" => true];
        }
        return ["status" => false, "error" => "Can not get post with id: " . $post_id];
    }

    public function getPosts ($request) {
        $pageSize = 10;
        $page = isset($request["page"]) && (int)$request["page"] > 0 ? (int)$request["page"] : 1;
        $user = wp_get_current_user();
        if(!$user || $user->ID == 0) {
            return ["status" => false, "error" => "You must login to get posts."];
        } 
        if($user && !in_array( 'editor', (array) $user->roles)) {
            return ["status" => false, "error" => "You don't have permission."];
        }
        $type = $request['type'];
        $args = array( 'post_type' =>  'post', 
            'posts_per_page' => $pageSize,
            'post_status' => array('draft', 'publish'),
            'orderby' => 'post_date',
			'order' => 'DESC', 
            'paged' => $page);
        if($type) {
            $args['meta_key'] = 'post_type';
            $args['meta_value'] = $type;
        }
        $meta_query = array();
        if($type) {
            $query = array(
                'key'   => 'post_type',
                'value' => $type,
            );
            array_push($meta_query, $query);
        }
        $args['meta_query'] = $meta_query;
        $posts = get_posts($args);
        $data = array();
        foreach ($posts as $post) {
            array_push($data, $this->createPostModel($post));
        }
        $total = wp_count_posts()->publish + wp_count_posts()->draft;
        return ["status" => true, "posts" => ["data" => $data, "current_page" => $page, "per_page" => $pageSize, "total" => $total]];
    }

    public function getUsers ($request) {
        $pageSize = 10;
        $page = isset($request["page"]) && (int)$request["page"] > 0 ? (int)$request["page"] : 1;
        $user = wp_get_current_user();
        if(!$user || $user->ID == 0) {
            return ["status" => false, "error" => "You must login to get posts."];
        } 
        if($user && !in_array( 'editor', (array) $user->roles)) {
            return ["status" => false, "error" => "You don't have permission."];
        }
        $args = array(
            'number' => $pageSize,
            'role__in'     => array('contributor', 'subscriber'),
            'orderby' => 'user_registered',
			'order' => 'DESC', 
            'paged' => $page);
        $data = array();
        $users = get_users( $args );
        foreach ($users as $item) {
            $user_id = $item->ID;
            $allowCreatePost = false;
            $user_roles = (array) $item->roles;
            if(in_array("editor", $user_roles)) {
                $allowCreatePost = true;
            }
            $object = [
                'ID'=> $item->ID,
                'display_name'=> $item->display_name,
                'user_email' => $item->user_email,
                'company_name' => get_user_meta($user_id, 'company_name', true),
                'address_line_1' => get_user_meta($user_id, ' address_line_1', true),
                'allowCreatePost' => $allowCreatePost
            ];
            array_push($data, $object);
        }
        $total = count(get_users(['role__in' => [ 'editor', 'subscriber' ]]));
        return ["status" => true, "users" => ["data" => $data, "current_page" => $page, "per_page" => $pageSize, "total" => $total]];
    }
    public function getPost ($request) {
        $user = wp_get_current_user();
        if(!$user) {
            return ["status" => false, "error" => "You must login to get posts."];
        } 
        if($user && !in_array( 'editor', (array) $user->roles)) {
            return ["status" => false, "error" => "You don't have permission."];
        }
        $validationRule = [
            "id" => "required"
        ];

        $validator = validate($request, $validationRule);
        if(!empty($validator)) {
            return ["status" => false, "error" => $validator];
        }
        try {
            $post_id = $request['id'];
            $post = get_post($post_id);
            if(!$post) {
                return ["status" => false, "error" => "Can not get post with id: " . $post_id];
            }
            return ["status" => true, "post" => $this->createPostModel($post)];
        } catch (\Exception $e) {
            return ["status" => false, "error" => $e->getMessage()];
        }
    }

    public function approve ($request) {
        $user = wp_get_current_user();
        if(!$user) {
            return ["status" => false, "error" => "You must login to get posts."];
        } 
        if($user && !in_array( 'editor', (array) $user->roles)) {
            return ["status" => false, "error" => "You don't have permission."];
        }
        $validationRule = [
            "id" => "required"
        ];

        $validator = validate($request, $validationRule);
        if(!empty($validator)) {
            return ["status" => false, "error" => $validator];
        }
        try {
            $post_id = $request['id'];
            $post = get_post($post_id);
            if(!$post) {
                return ["status" => false, "error" => "Can not get post with id: " . $post_id];
            }
            $post_state = strtolower(get_post_meta($post_id, 'post_state', true));
            if ('submitted' == $post_state) {
                update_post_meta($post_id, 'post_state', 'published');
                return ["status" => true, "post" => [ "_id" => $post_id, "state" => 'published']];
            }
        } catch (\Exception $e) {
            return ["status" => false, "error" => $e->getMessage()];
        }
    }

    public function reject ($request) {
        $user = wp_get_current_user();
        if(!$user) {
            return ["status" => false, "error" => "You must login to get posts."];
        } 
        if($user && !in_array( 'editor', (array) $user->roles)) {
            return ["status" => false, "error" => "You don't have permission."];
        }
        $validationRule = [
            "id" => "required"
        ];

        $validator = validate($request, $validationRule);
        if(!empty($validator)) {
            return ["status" => false, "error" => $validator];
        }
        try {
            $post_id = $request['id'];
            $post = get_post($post_id);
            $author = get_user_by('ID', $post->post_author);
            if(!$post) {
                return ["status" => false, "error" => "Can not get post with id: " . $post_id];
            }
            $post_state = strtolower(get_post_meta($post_id, 'post_state', true));
            if ('submitted' == $post_state) {
                update_post_meta($post_id, 'post_state', 'rejected');
                $to = isset($author) ? $author->user_email : null;
                $subject = 'Reject message for post: ' . get_the_title($post_id);
                $message = 'Rejecting reason: ' . isset($request["message"]) ? $request["message"] : '';
                wp_mail( $to, $subject, $message );
                return ["status" => true, "post" => [ "_id" => $post_id, "state" => "rejected", "rejectMessage" => $message]];
            }
        } catch (\Exception $e) {
            return ["status" => false, "error" => $e->getMessage()];
        }
    }
    public function updateAllowCreatePost ($request) {
        $user = wp_get_current_user();
        if(!$user) {
            return ["status" => false, "error" => "You must login to get posts."];
        } 
        if($user && !in_array( 'editor', (array) $user->roles)) {
            return ["status" => false, "error" => "You don't have permission."];
        }
        $validationRule = [
            "id" => "required"
        ];
        $validator = validate($request, $validationRule);
        if(!empty($validator)) {
            return ["status" => false, "error" => $validator];
        }
        $id = $request['id']; 
        $update_user = get_user_by('ID', $id);
        if($update_user) {
            $user_roles = (array) $update_user->roles;
            if(in_array("contributor", $user_roles)) {
                $update_user->remove_role( 'contributor' );
                $update_user->add_role( 'subscriber' );
                $allowCreatePost = false;
            } else if(in_array("subscriber", $user_roles)) {
                $update_user->remove_role( 'subscriber' );
                $update_user->add_role( 'contributor' );
                $allowCreatePost = true;
            }
            return ["status" => true, "data" => [
                "userId" => $update_user->ID, 
                "allowCreatePost" => $allowCreatePost
            ]];
        }
        return ["status" => false, "error" => "Cannot get user with id: " . $id];
    }
    function createPostModel($post) {
        $post_id = $post->ID;
        
        $model = [
            "ID" => $post_id,
            "headline" => isset($post->post_title) ? $post->post_title : "",
            "preamble" => isset($post->post_excerpt) ? $post->post_excerpt : "",
            "tags" => get_the_tags($post_id),
            "post_author" => get_user_by('ID', $post->post_author)->display_name,
            "url" => get_permalink($post_id),
            "mainImageUrl" => get_the_post_thumbnail_url($post_id, 'pi-large-thumbnail'),
            "thumbnailUrl" => get_the_post_thumbnail_url($post_id, 'pi-large-thumbnail'),
            "state" => strtolower(get_post_meta($post_id, 'post_state', true)),
            "type" => strtolower(get_post_meta($post_id, 'post_type', true)),
            "acceptTerm" =>  get_post_meta($post_id, 'accept_term', true) == 'true' ? true : false
        ];
        $authors = get_field('authors', $post_id);
        $author_list = $authors && count($authors) > 0 ? $authors[0]["display_name"] : '';
        if($authors && count($authors) > 1) {
            for($i=1; $i<count($authors); $i++) {
                $author_list = $author_list . ', ' . $authors[$i]["display_name"];
            }
        }
        $model["authors"] = $author_list;
        return $model;
    }
}