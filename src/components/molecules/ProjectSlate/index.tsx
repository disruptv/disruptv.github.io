import React, { ReactComponentElement } from "react";
import { Link } from "react-router-dom";
import htmlDecode from "../../../utils/htmlDecode";
import styles from "./index.module.scss";
import browser from "../../../utils/browserDetection";

const ProjectSlate = (props: any): ReactComponentElement<"article"> => {
  let { title, slug, featured_image_url: image } = props;

  title = htmlDecode(title.rendered);

  return (
    <article
      className={styles.container}
      style={{
        backgroundImage: `url(${image[0]}`,
        backgroundAttachment: browser === "Apple Safari" ? "inherit" : "fixed",
      }}
    >
      <h2 className={styles.title}>{title}</h2>
      <Link to={`project/${slug}`}></Link>
    </article>
  );
};

export default ProjectSlate;
