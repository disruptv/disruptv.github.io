import React from "react";
import { Link } from "react-router-dom";
import styles from "./index.module.scss";

const ProjectSlate = (props: any) => {
  const { title, slug } = props;

  return (
    <article className={styles.container}>
      <h2 className={styles.title}>{title.rendered}</h2>
      <Link to={`project/${slug}`}></Link>
    </article>
  );
};

export default ProjectSlate;
