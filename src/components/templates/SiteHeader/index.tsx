import React from "react";
import { connect } from "react-redux";
import NavItems from "../../organisms/SiteNav";
import styles from "./index.module.scss";

const mapPropsToState = (state: any, ownProps: any) => {
  const { menus } = state;
  return {
    siteNav: menus.SiteNav,
  };
};

const SiteHeader = (props: any) => {
  return (
    <header className={styles.container}>
      <a href='/' className={styles.SiteLogo}>
        Disruptv LLC
      </a>
      <nav>
        <NavItems items={props.siteNav} />
      </nav>
    </header>
  );
};

export default connect(mapPropsToState)(SiteHeader);
