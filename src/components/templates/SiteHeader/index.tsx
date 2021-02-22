import React from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
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
      <Link to='/' className={styles.SiteLogo}>
        Disruptv LLC
      </Link>
      <nav>
        <NavItems items={props.siteNav} />
      </nav>
    </header>
  );
};

export default connect(mapPropsToState)(SiteHeader);
