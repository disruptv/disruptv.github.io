import React from "react";
import { connect } from "react-redux";
import ProjectSlate from "../../molecules/ProjectSlate";
import styles from "./index.module.scss";

const mapStateToProps = (state: any, ownProps: any) => {
  const { projects, home } = state;
  return {
    projects,
    home,
  };
};

const Home = (props: any) => {
  const { title, excerpt } = props.home;

  let intro = excerpt.split("</br>");
  intro = intro.map((p: string, i: number) => {
    return <p key={i}>{p}</p>;
  });

  const projects = props.projects.map((project: any, i: number) => {
    return <ProjectSlate {...project} key={i} />;
  });

  return (
    <main className={styles.container}>
      <section className={styles.Section__intro}>
        <h1>
          <small>Hey there,</small>
          {title}
        </h1>
        <div className={styles.intro}>{intro}</div>
      </section>
      {/* <section className={styles.Section__showcase}>{projects}</section> */}
    </main>
  );
};

export default connect(mapStateToProps)(Home);
