/* eslint-disable require-jsdoc */
import React from "react";
import { connect } from "react-redux";
import { useParams } from "react-router-dom";
import logger from "../../../utils/logger";

const mapStateToProps = (state: any, ownProps: any) => {
  const { pages } = state;
  return { pages };
};
// const { id }: any = useParams();

class Project extends React.Component<any, any> {
  constructor(props: any) {
    super(props);

    this.state = {};
  }

  componentDidUpdate(prevProps: any) {
    if (prevProps.pages !== this.props.pages) {
      this.setState({});
    }
  }

  render() {
    return (
      <article>
        <header>
          <h1></h1>
        </header>
        <section></section>
        <footer></footer>
      </article>
    );
  }
}

export default connect(mapStateToProps)(Project);
