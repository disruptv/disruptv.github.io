import React from "react";
import { connect } from "react-redux";
import { useParams } from "react-router-dom";
import logger from "../../../utils/logger";
import styles from "./index.module.scss";

const mapStateToProps = (state: any, ownProps: any) => {
  const { pages } = state;
  return { pages };
};
// const { id }: any = useParams();

class Project extends React.Component<any, any> {
  constructor(props: any) {
    super(props);

    this.state = {
      id: 1,
      client: "Client Brand",
      title: "Project Title",
      date: new Date().getFullYear(),
      excerpt: `Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore magna aliqua. Habitasse
      platea dictumst quisque sagittis purus. Ornare quam viverra orci
      sagittis eu volutpat odio. Sed libero enim sed faucibus. Vel eros
      donec ac odio tempor orci dapibus ultrices in. Feugiat vivamus at
      augue eget arcu dictum varius duis at. Pellentesque nec nam aliquam
      sem. In nibh mauris cursus mattis molestie a. Tincidunt praesent
      semper feugiat nibh sed. Sed arcu non odio euismod lacinia at quis
      risus sed. A lacus vestibulum sed arcu non odio euismod. Porttitor
      lacus luctus accumsan tortor posuere ac ut consequat. Pharetra sit
      amet aliquam id diam maecenas ultricies mi eget. Pellentesque habitant
      morbi tristique senectus et netus et malesuada fames. Neque vitae
      tempus quam pellentesque. Suspendisse interdum consectetur libero id
      faucibus nisl. Arcu dui vivamus arcu felis bibendum ut tristique et
      egestas. Commodo sed egestas egestas fringilla phasellus faucibus
      scelerisque eleifend donec. Adipiscing tristique risus nec feugiat.
      Pellentesque massa placerat duis ultricies lacus sed.`,
      content: `Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam
      elementum pulvinar etiam non quam lacus suspendisse faucibus interdum.
      Volutpat diam ut venenatis tellus in metus. Tortor posuere ac ut
      consequat semper viverra.</br> Habitant morbi tristique senectus et netus
      et malesuada fames. Id volutpat lacus laoreet non curabitur gravida
      arcu. Consectetur adipiscing elit ut aliquam purus sit amet luctus
      venenatis. Netus et malesuada fames ac turpis. Lacus sed viverra
      tellus in hac habitasse platea. Ultricies lacus sed turpis tincidunt
      id aliquet risus. Malesuada pellentesque elit eget gravida cum sociis.
      Iaculis eu non diam phasellus vestibulum lorem. Ullamcorper malesuada
      proin libero nunc consequat interdum varius. Urna porttitor rhoncus
      dolor purus non enim.</br> Eu nisl nunc mi ipsum faucibus. Nibh cras
      pulvinar mattis nunc. Dictumst quisque sagittis purus sit amet
      volutpat consequat. Accumsan tortor posuere ac ut. Nunc mattis enim ut
      tellus. Faucibus turpis in eu mi bibendum neque egestas congue.
      Euismod lacinia at quis risus sed vulputate odio ut. A arcu cursus
      vitae congue mauris rhoncus. Amet cursus sit amet dictum. Mi proin sed
      libero enim sed faucibus turpis in eu.</br> Gravida rutrum quisque non
      tellus orci ac. Erat imperdiet sed euismod nisi porta lorem mollis
      aliquam ut. Nunc sed augue lacus viverra vitae congue eu consequat ac.
      Dictum sit amet justo donec enim. Id aliquet risus feugiat in ante
      metus. Nulla facilisi morbi tempus iaculis urna id volutpat lacus.
      Integer vitae justo eget magna fermentum iaculis. Orci dapibus
      ultrices in iaculis nunc sed augue lacus.</br> Auctor urna nunc id cursus.
      Aenean pharetra magna ac placerat vestibulum lectus mauris. Neque
      vitae tempus quam pellentesque nec nam aliquam sem. Aliquet enim
      tortor at auctor urna nunc. Nisi lacus sed viverra tellus in hac
      habitasse. Imperdiet proin fermentum leo vel orci porta non pulvinar.
      Quam viverra orci sagittis eu volutpat odio facilisis mauris. Gravida
      cum sociis natoque penatibus. Id velit ut tortor pretium viverra
      suspendisse potenti. Id velit ut tortor pretium.</br> Tortor at risus
      viverra adipiscing at in tellus integer. Aliquet lectus proin nibh
      nisl. Tempor id eu nisl nunc. Quis enim lobortis scelerisque
      fermentum. Mauris pellentesque pulvinar pellentesque habitant morbi
      tristique. Sed elementum tempus egestas sed sed risus pretium quam.
      Tellus at urna condimentum mattis. Aliquet eget sit amet tellus cras
      adipiscing enim. Sodales ut eu sem integer vitae justo. Egestas
      egestas fringilla phasellus faucibus. Tortor aliquam nulla facilisi
      cras. Pharetra vel turpis nunc eget lorem. Lorem sed risus ultricies
      tristique nulla aliquet enim tortor at.</br> Arcu felis bibendum ut
      tristique et. Parturient montes nascetur ridiculus mus mauris vitae
      ultricies. Mauris pharetra et ultrices neque. Eu nisl nunc mi ipsum
      faucibus vitae aliquet nec ullamcorper. Netus et malesuada fames ac
      turpis egestas integer eget. Eget lorem dolor sed viverra ipsum nunc
      aliquet bibendum. A cras semper auctor neque vitae tempus quam
      pellentesque. Maecenas ultricies mi eget mauris pharetra. Eget nulla
      facilisi etiam dignissim diam quis enim lobortis scelerisque. Elit ut
      aliquam purus sit. Diam in arcu cursus euismod quis. Semper feugiat
      nibh sed pulvinar proin gravida. Viverra nibh cras pulvinar mattis.`,
      skills: ["semper auctor", "tellus integer", "augue lacus"],
      platforms: [
        "iOS",
        "Android",
        "React",
        "Wordpress",
        "React Native",
        "web",
      ],
    };
  }

  componentDidUpdate(prevProps: any) {
    if (prevProps.pages !== this.props.pages) {
      this.setState({});
    }
  }

  ComposeLists = (props: any) => {
    return props.items.map((item: any, i: number) => {
      return <li key={i}>{item}</li>;
    });
  };

  render() {
    return (
      <article className={styles.container}>
        <header className={styles.slate}>
          <h1 className={styles.client}>{this.state.client}</h1>
          <h2 className={styles.title}>{this.state.title}</h2>
          <p className={styles.excerpt}>{this.state.excerpt}</p>
          <aside className={styles.details}>
            <ul className={styles.skills}>
              <h3>Skills</h3>
              <this.ComposeLists items={this.state.skills} />
            </ul>
            <ul className={styles.platforms}>
              <h3>Platforms</h3>
              <this.ComposeLists items={this.state.platforms} />
            </ul>
            <time className={styles.date} dateTime={this.state.date}>
              <h3>Date</h3>
              {this.state.date}
            </time>
          </aside>
        </header>
        <section
          className={styles.content}
          dangerouslySetInnerHTML={{ __html: this.state.content }}
        ></section>
        <footer></footer>
      </article>
    );
  }
}

export default connect(mapStateToProps)(Project);
