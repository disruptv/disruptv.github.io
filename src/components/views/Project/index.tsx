import React from "react";
import { connect } from "react-redux";

const mapStateToProps = () => {
  return {};
};

const Project = () => {
  return (
    <article>
      <header>
        <h1></h1>
      </header>
      <section></section>
      <footer></footer>
    </article>
  );
};

export default connect(mapStateToProps)(Project);
