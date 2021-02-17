import React from "react";
import { connect } from "react-redux";
import SocialMenu from "../../organisms/SocialMenu";
import styles from "./index.module.scss";

const mapPropsToState = (state: any, ownProps: any) => {
  const { menus } = state;
  return {
    socialMenu: menus.SocialMenu,
  };
};

const SiteFooter = (props: any) => {
  return (
    <footer className={styles.container}>
      <menu>
        <SocialMenu items={props.socialMenu} />
      </menu>
    </footer>
  );
};

export default connect(mapPropsToState)(SiteFooter);
