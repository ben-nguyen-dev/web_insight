<?php

class ApiBaseController extends WP_REST_Controller {
    var $namespace = 'api/';
    
    public function register_routes() {
        $mypost_namespace = $this->namespace . 'my-post';
        register_rest_route($mypost_namespace, '/list', array(
                array(
                    'methods'  => 'GET',
                    'callback' => array(new ApiDefaultController('list'), 'init'),
                )
            )
        );
        register_rest_route($mypost_namespace, '/get', array(
                array(
                    'methods'  => 'GET',
                    'callback' => array(new ApiDefaultController('show'), 'init'),
                )
            )
        );
        register_rest_route($mypost_namespace, '/save', array(
                array(
                    'methods'  => 'POST',
                    'callback' => array(new ApiDefaultController('save'), 'init'),
                )
            )
        );
        register_rest_route($mypost_namespace, '/delete', array(
            array(
                'methods'  => 'DELETE',
                'callback' => array(new ApiDefaultController('delete'), 'init'),
            )
            )
        );
        $tag_namespace = $this->namespace . 'tag';
        register_rest_route($tag_namespace, '/search', array(
                array(
                    'methods'  => 'GET',
                    'callback' => array(new ApiDefaultController('getTags'), 'init'),
                )
            )
        );
        $author_namespace = $this->namespace . 'author';
        register_rest_route($author_namespace, '/search', array(
                array(
                    'methods'  => 'GET',
                    'callback' => array(new ApiDefaultController('getAuthors'), 'init'),
                )
            )
        );
        $post_namespace = $this->namespace . 'post';
        register_rest_route($post_namespace, '/list', array(
                array(
                    'methods'  => 'GET',
                    'callback' => array(new ApiDefaultController('getPosts'), 'init'),
                )
            )
        );
        register_rest_route($post_namespace, '/get', array(
            array(
                'methods'  => 'GET',
                'callback' => array(new ApiDefaultController('getPost'), 'init'),
            )
        )
    );
        register_rest_route($post_namespace, '/approve', array(
                array(
                    'methods'  => 'POST',
                    'callback' => array(new ApiDefaultController('approve'), 'init'),
                )
            )
        );
        register_rest_route($post_namespace, '/reject', array(
                array(
                    'methods'  => 'POST',
                    'callback' => array(new ApiDefaultController('reject'), 'init'),
                )
            )
        );
        $user_namespace = $this->namespace . 'user';
        register_rest_route($user_namespace, '/getUsers', array(
                array(
                    'methods'  => 'GET',
                    'callback' => array(new ApiDefaultController('getUsers'), 'init'),
                )
            )
        );
        register_rest_route($user_namespace, '/updateAllowCreatePost', array(
                array(
                    'methods'  => 'PUT',
                    'callback' => array(new ApiDefaultController('updateAllowCreatePost'), 'init'),
                )
            )
        );
    }
    public function hook_rest_server() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }
}

$ApiBaseController = new ApiBaseController();
$ApiBaseController->hook_rest_server();