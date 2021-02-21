import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { withRouter } from "react-router-dom";
import sleep from "../../../utils/sleep";
import SocialMenu from "../../organisms/SocialMenu";
import styles from "./index.module.scss";

const mapPropsToState = (state: any, ownProps: any) => {
  const { menus, ready } = state;

  return {
    socialMenu: menus.SocialMenu,
    ready,
    body: document.body as HTMLElement,
    timing: getComputedStyle(document.documentElement).getPropertyValue(
      "--timing"
    ),
  };
};

const SiteFooter = (props: any) => {
  const [isDocked, dock] = useState(false);
  let [classes, setClasses] = useState(["container", "docked"]);

  useEffect(
    ({ body, timing } = props) => {
      body.addEventListener("scroll", () => {
        body.scrollTop === 0 ? dock(false) : dock(true);
      });

      return () => {
        // TODO: fix jankiness when quick scrolling at the top of the page
        const animationClasses = async () => {
          !classes.includes("inTransit--start")
            ? classes.push("inTransit--start")
            : classes.push();
          setClasses(classes);
          await sleep(0.01);

          classes = classes.filter(
            (className: string) => className !== "inTransit--start"
          );
          !classes.includes("inTransit")
            ? classes.push("inTransit")
            : classes.push();
          if (isDocked && !classes.includes("docked")) {
            classes.push("docked");
          } else if (!isDocked) {
            classes = classes.filter(
              (className: string) => className !== "docked"
            );
          }
          setClasses(classes);

          await sleep(timing);

          const endTransit = classes.filter(
            (className: string) => className !== "inTransit"
          );
          setClasses(endTransit.filter(Boolean));
        };
        animationClasses();
      };
    },
    [isDocked]
  );

  const classNames = classes.map((className: string) => {
    return styles[className];
  });

  return (
    <footer className={classNames.join(" ")}>
      <menu className={styles.SocialMenu}>
        <SocialMenu items={props.socialMenu} />
      </menu>
      <small className={styles.copyright}>
        © Copyright Disruptv LLC {new Date().getFullYear()}
      </small>
    </footer>
  );
};

export default withRouter(connect(mapPropsToState)(SiteFooter));
