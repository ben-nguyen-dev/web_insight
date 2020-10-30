import View from './index';
import { connect } from "react-redux";
import {dispatchSetLoading} from '../../components/Spinner/action';

const mapDispatchToProps =
{
  dispatchSetLoading
};

export default connect(() => ({}), mapDispatchToProps)(View);