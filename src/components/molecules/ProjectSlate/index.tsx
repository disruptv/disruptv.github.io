import React, { ReactComponentElement } from "react";
import { Link } from "react-router-dom";
import htmlDecode from "../../../utils/htmlDecode";
import styles from "./index.module.scss";

const ProjectSlate = (props: any): ReactComponentElement<"article"> => {
  let { title, slug } = props;
  title = htmlDecode(title.rendered);

  return (
    <article className={styles.container}>
      <h2 className={styles.title}>{title}</h2>
      <Link to={`project/${slug}`}></Link>
    </article>
  );
};

export default ProjectSlate;
