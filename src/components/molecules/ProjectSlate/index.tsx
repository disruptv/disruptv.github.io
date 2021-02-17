import React from "react";
import styles from "./index.module.scss";

const ProjectSlate = (props: any) => {
  console.log(props);
  const { title, link } = props;
  return (
    <article className={styles.container}>
      <h2 className={styles.title}>{title.rendered}</h2>
      <a href={link}></a>
    </article>
  );
};

export default ProjectSlate;
