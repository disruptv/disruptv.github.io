import React from "react";
import { connect } from "react-redux";
import styles from "./index.module.scss";

const mapStateToProps = (state: any, ownProps: any) => {
  const { projects } = state;
  return {
    projects: projects,
    page: {
      title: `I work with startups and top companies to
      design intentional, radical, innovative digital products.`,
      excerpt: `I'm Aaron Salley. My philosophy leverages connections between
      diverse experiences. Having been in the arts and tech, I have an
      uncommon mix of heart-centered, mission-driven values, and a
      pragmatic, nimble ability to execute; as an industry-disruptive
      innovator focused on the collective advancement of global society, I
      bring conscientiousness, creativity, and strategic thinking to all
      that I do.`,
    },
  };
};

const Home = (props: any) => {
  const { title, excerpt } = props.page;
  return (
    <main className={styles.container}>
      <section className={styles.Section__intro}>
        <h1>
          <small>Hey there,</small>
          {title}
        </h1>
        <p>{excerpt}</p>
      </section>
    </main>
  );
};

export default connect(mapStateToProps)(Home);
