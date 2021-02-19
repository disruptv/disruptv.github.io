import React, { ReactComponentElement } from "react";
import styles from "./index.module.scss";

const SocialMenuItem = (props: any) => {
  let { classes = [], url, title } = props;
  classes.push("item");
  classes = classes.filter(Boolean);

  const icon = title.toLowerCase();

  return (
    <li
      className={classes.map((className: string) => {
        return styles[className];
      })}
    >
      <a href={url} target='_blank' rel='noreferrer'>
        <i className={"fab fa-" + icon}></i>
      </a>
    </li>
  );
};

const SocialMenu = (props: any): ReactComponentElement<"ul"> => {
  const items = props.items.map((item: any, i: number) => {
    return <SocialMenuItem {...item} key={i} />;
  });

  return <ul className={styles.container}>{items}</ul>;
};

export default SocialMenu;
