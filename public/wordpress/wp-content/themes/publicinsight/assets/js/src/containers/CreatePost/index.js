import React, { Component } from "react";
import {connect} from 'react-redux'
import {
  Form,
  Input,
  FormGroup,
  CustomInput,
  Button,
  Alert,
} from "reactstrap";
import { Link } from "react-router-dom";
import CKEditor from "ckeditor4-react";
import { createPost, getTags, getAuthors } from "../../api";
import { dispatchSetLoading } from "../../components/Spinner/action";
import blockTools from "@sanity/block-tools";
import Schema from "@sanity/schema";
import CreatableSelect from "react-select/creatable";
import { getDetailPost } from "../../api";
import AlertModal from "./alertModal";
const defaultImage = require("../../assets/Image/default_image.jpg");
// image khong doi, gui null
// image remove,

// khong co => null
// remove => khong gui
const defaultSchema = Schema.compile({
  name: "myBlog",
  types: [
    {
      type: "object",
      name: "blogPost",
      fields: [
        {
          title: "Title",
          type: "string",
          name: "title",
        },
        {
          title: "Body",
          name: "body",
          type: "array",
          of: [
            {
              type: "image",
              fields: [
                {
                  type: "text",
                  name: "alt",
                  title: "Alternative text",
                  options: {
                    isHighlighted: true,
                  },
                },
              ],
            },
            { type: "block" },
          ],
        },
      ],
    },
  ],
});

const blockContentType = defaultSchema
  .get("blogPost")
  .fields.find((field) => field.name === "body").type;

class CreatePost extends Component {
  constructor(props) {
    super(props);
    this.state = {
      _id: "",
      avatarUpload: null,
      avatar: null,
      avatarOld: null,
      body: "",
      bodyPortable: "",
      headline: "",
      preamble: "",
      tags: "",
      author: "",
      acceptTerm: false,
      actionType: "draft",
      showAlertAcceptTerm: false,
      showAlertHeadline: false,
      showAlertPreamble: false,
      showAlertBody: false,
      showAlertImage: false,
      optionsTag: [],
      optionsAuthor: [],
      isOpenModal: false,
      message: "",
      edited: false,
      callback: null,
      noCancel: false
    };
  }

  onBack = () => {
    const { edited } = this.state
    if (edited) {
      this.setState({
        isOpenModal: true,
        message: "Content has changed, are you sure to discard your changes and back to list?",
        callback: () => {
          window.location.href = "/myposts"
        }
      })

      return
    } 

    window.location.href = "/myposts"
  }

  searchTags = async (page) => {
    try {
      const res = await getTags(1);
      const options = res.data.data.map((e) => ({
        value: e.name,
        label: e.name,
      }));
      this.setState({ optionsTag: options });
    } catch {}
  };

  searchAuthors= async (page) => {
    try {
      const res = await getAuthors(1);
      const options = res.data.data.map((e) => ({
        value: e.name,
        label: e.name,
      }));
      this.setState({ optionsAuthor: options });
    } catch {}
  }

  getDetailPost = async (_id) => {
    try {
      this.props.dispatchSetLoading(true);
      const res = await getDetailPost(_id);
      const post = res.data.post;
      this.setState({
        body: post.body,
        preamble: post.preamble,
        headline: post.headline,
        _id: post._id,
        avatar: post.mainImageUrl,
        avatarOld: post.mainImageUrl,
        tags: post.tags.map((e)=> e.name),
        author: post.authors.map((e) => e.name),
        acceptTerm: post.acceptTerm
      });
      this.props.dispatchSetLoading(false);
    } catch {
      this.props.dispatchSetLoading(false);
    }
  };

  removePTagInList = bodyString => bodyString.replace(/<li>\n\t<p>/g, "<li>").replace(/<\/p>\n\t<\/li>/g, "</li>")

  componentDidMount = () => {
    const id = this.getPostId()
    if (id) this.getDetailPost(id)
    this.searchTags(1);
    this.searchAuthors(1)
  };

  getPostId = () => {
    const arr = this.props?.location?.pathname.split("/")
    return arr[2]
  }

  checkEmpty = () => {
    const { headline, acceptTerm, preamble, body, avatar } = this.state;
    let check = 0;
    if (headline === "") {
      this.setState({ showAlertHeadline: true });
      check = 1;
    }
    if (!acceptTerm) {
      this.setState({ showAlertAcceptTerm: true });
      check = 1;
    }
    if (preamble === "") {
      this.setState({ showAlertPreamble: true });
      check = 1;
    }
    if (avatar === null) {
      this.setState({ showAlertImage: true });
      check = 1;
    }
    if (body === "") {
      this.setState({ showAlertBody: true });
      check = 1;
    }
    return check;
  };

  onCreatePost = async (action) => {
    const {
      _id,
      avatar,
      preamble,
      tags,
      body,
      bodyPortable,
      headline,
      author,
      avatarOld,
      acceptTerm,
      avatarUpload,
    } = this.state;

    if (action === "submit") {
      if (this.checkEmpty()) return;
    } else
      this.setState({
        showAlertImage: false,
        showAlertPreamble: false,
        showAlertHeadline: false,
        showAlertAcceptTerm: false,
        showAlertBody: false,
      });

    try {
      this.props.dispatchSetLoading(true);
      let formData = new FormData();

      if (_id) formData.append("_id", _id);
      formData.append("headline", headline);
      formData.append("preamble", preamble);
      formData.append("actionType", action);
      formData.append("body", bodyPortable);
      formData.append("tags", this.state.tags);
      formData.append("authors", this.state.author);
      formData.append("acceptTerm", acceptTerm);

      if (avatarOld !== null) {
        if (avatar === null) formData.append("mainImage", null); // remove
        if (avatar !== avatarOld)
          formData.append("mainImage", avatarUpload.file); // thay đổi
      }

      if (avatarOld === null) {
        if (avatar !== null) formData.append("mainImage", avatarUpload.file); // thêm mới
      }

      const res = await createPost(formData);
      if (res.data && !res.data.status) throw new Error(res.data.error)

      // lưu lại id sau khi gọi api
      if (_id === "") this.setState({ _id: res.data.post._id });
      // lưu ảnh
      if (res.data.mainImageUrl) {
        this.setState({
          avatar: res.data.post.mainImageUrl,
          avatarOld: res.data.post.mainImageUrl,
        });
      } else {
        this.setState({ avatarOld: avatar });
      }
      this.props.dispatchSetLoading(false);
      this.setState({
        isOpenModal: true,
        message:
          action === "draft"
            ? "The post has been saved successfully"
            : "The post has been saved and submitted successfully",
        edited: false,
        callback: () => window.location.href = "/myposts",
        noCancel: true
      });
    } catch (err) {
      this.props.dispatchSetLoading(false);
      this.setState({
        isOpenModal: true,
        message: err.message,
      });
      console.log(err);
    }
  };

  toggle = () => {
    this.setState({ isOpenModal: !this.state.isOpenModal, callback: null, noCancel: false });
  };

  returnOption = (option) => {
    const arr = option.map((e) => ({value: e, label: e}))
    return arr
  }

  setEdited = status => this.setState({edited: status})

  render() {
    const {
      avatar,
      body,
      bodyPortable,
      headline,
      preamble,
      tags,
      author,
      acceptTerm,
      showAlertAcceptTerm,
      showAlertHeadline,
      showAlertPreamble,
      showAlertBody,
      showAlertImage,
      isOpenModal,
    } = this.state;
    return (
      <div className="container"> 
        <div className="p-3">
          <h5 className="mb-2">{`${this.getPostId() ? "EDIT" : "CREATE"} POST`}</h5>
          <Form
            ref={(ref) => {
              this.form = ref;
            }}
            onSubmit={(e) => console.log("submit ", e)}
          >
            <div className="mb-5">
              <h6>Headline</h6>
              <FormGroup>
                <Input
                  name="headline"
                  id="headline"
                  bsSize="sm"
                  value={headline}
                  onChange={(e) => this.setState({ headline: e.target.value })}
                  onKeyUp={() => this.setEdited(true)}
                />
                {showAlertHeadline && headline === "" && (
                  <Alert className="mt-2" color="danger">
                    Headline must not be empty
                  </Alert>
                )}
              </FormGroup>
            </div>

            <div className="mb-5">
              <h6>Preamble</h6>
              <FormGroup>
                <Input
                  name="preamble"
                  id="preamble"
                  bsSize="sm"
                  value={preamble}
                  onChange={(e) => this.setState({ preamble: e.target.value })}
                  onKeyUp={() => this.setEdited(true)}
                />
                {showAlertPreamble && preamble === "" && (
                  <Alert className="mt-2" color="danger">
                    Preamble must not be empty
                  </Alert>
                )}
              </FormGroup>
            </div>

            <div className="mb-5">
              <h6>Body</h6>
              <CKEditor
                data={this.state.body}
                config={{
                  allowedContent: true,
                  removePlugins: "Paste",
                  toolbar: [
                    [
                      "Bold",
                      "Italic",
                      "Strike",
                      "Undo",
                      "Redo",
                      "Underline",
                      "NumberedList",
                      "BulletedList",
                      "Link"
                    ],
                  ],
                }}
                onChange={async (e) => {
                  if (bodyPortable && bodyPortable.trim()) {
                    await this.setState({ edited: true })
                  }
                  this.setState(
                    {
                      body: e.editor.getData(),
                      bodyPortable: JSON.stringify(blockTools.htmlToBlocks(
                        this.removePTagInList(e.editor.getData()),
                        blockContentType
                      )),
                    }
                  );
                }}
              />
              {showAlertBody && body === "" && (
                <Alert className="mt-2" color="danger">
                  Body must not be empty
                </Alert>
              )}
            </div>

            <div className="mb-5">
              <h6>Tags</h6>
              <CreatableSelect
                value={tags ? this.returnOption(tags): null}
                isMulti
                options={this.state.optionsTag}
                className="small"
                styles={{ height: "32px" }}
                onChange={(e) =>
                  this.setState({ tags: e ? e.map((e) => e.value) : "" })
                }
                onMenuOpen={() => this.setEdited(true)}
              />
            </div>

            <div className="mb-5">
              <h6>Author</h6>
              <CreatableSelect
                value={author ? this.returnOption(author): null}
                isMulti
                options={this.state.optionsAuthor}
                className="small"
                styles={{ height: "32px" }}
                onChange={(e) =>
                  this.setState({ author: e ? e.map((e) => e.value) : "" })
                }
                onMenuOpen={() => this.setEdited(true)}

              />
            </div>
            <div className="mb-5">
              <h6>Image (max size: 2mb)</h6>
              <img
                src={this.state.avatar || defaultImage}
                alt="avatar"
                className=" center-cropped mb-3"
                style={{ width: "100%", height: "500px", objectFit: "cover" }}
              />
              <input
                onChange={(e) => {
                  if (e.target.files[0]) {
                    this.setState({
                      avatar: window.URL.createObjectURL(e.target.files[0]),
                      avatarUpload: {
                        file: e.target.files[0],
                        name: e.target.files[0].name,
                      },
                    });
                  }
                }}
                type={"file"}
                ref={(ref) => {
                  this.imagePicker = ref;
                }}
                className="d-none"
              />
              {showAlertImage && avatar === null && (
                <Alert className="mt-2" color="danger">
                  Image must not be empty
                </Alert>
              )}
              <Button
                outline
                color="primary"
                className="mr-2"
                size="sm"
                onClick={() => {
                  this.setEdited(true)
                  this.imagePicker.click()
                }}
              >
                Browser
              </Button>{" "}
              <Button
                outline
                color="secondary"
                size="sm"
                onClick={() => this.setState({ avatar: null, edited: true })}
              >
                Remove
              </Button>{" "}
            </div>
            <div className="mb-5">
              <CustomInput
                type="switch"
                id="exampleCustomSwitch"
                name="customSwitch"
                label="Accept terms and condition"
                checked={acceptTerm}
                onChange={(e) =>
                  this.setState({ acceptTerm: e.target.checked })
                }
                onKeyUp={() => this.setEdited(true)}

              />
              {showAlertAcceptTerm && !acceptTerm && (
                <Alert className="mt-2" color="danger">
                  You must accept terms and condition
                </Alert>
              )}
            </div>
          </Form>
          <div className="border d-flex flex-row align-items-center justyfi-content-between">
            <div>
              <Button
                color="primary"
                className="mr-2 px-3"
                size="sm"
                onClick={() => this.onCreatePost("draft")}
              >
                Save as draft
              </Button>{" "}
              <Button
                color="danger"
                size="sm"
                className="mr-2 px-3"
                onClick={() => this.onCreatePost("submit")}
              >
                Save and submit
              </Button>{" "}
            </div>
            <div>
              <Button
                color="warning"
                size="sm"
                className="mr-2 px-3"
                onClick={() => this.onBack()}
              >
                Back to list
              </Button>{" "}
            </div>
          </div>
          <AlertModal
            isOpen={isOpenModal}
            toggle={this.toggle}
            message={this.state.message}
            callback={this.state.callback}
            noCancel={this.state.noCancel}
          />
        </div>
      </div>
    );
  }
}

const mapDispatchToProps = {
  dispatchSetLoading
}

export default connect(
  null,
  mapDispatchToProps
)(CreatePost)
