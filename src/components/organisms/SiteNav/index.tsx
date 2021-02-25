import React, { ReactComponentElement } from "react";
import { NavLink } from "react-router-dom";
import styles from "./index.module.scss";

const SiteNavItem = (props: any) => {
  let {
    classes = [],
    url = "",
    title = "",
  }: { classes: any; url: string; title: string } = props;
  classes.push("item");
  classes = classes.filter(Boolean);

  url = url.split("/").splice(3).filter(Boolean).join("/");

  return (
    <li
      className={classes.map((className: string) => {
        return styles[className];
      })}
    >
      <NavLink to={`/${url}`}>{title}</NavLink>
    </li>
  );
};

const SiteNav = (props: any): ReactComponentElement<"ul"> => {
  const items = props.items.map((item: any, i: number) => {
    return <SiteNavItem {...item} key={i} />;
  });

  return <ul className={styles.container}>{items}</ul>;
};

export default SiteNav;
