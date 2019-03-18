'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

class Projects extends Component {
  constructor(props){
    super(props);
    this.state = {
      projects: [],
    }
  };

  async componentWillMount(){
    // const response = await axios.get( '/v2/users/aaronsalley/projects', {
    //   baseURL: 'https://api.behance.net',
    //   params: {
    //     client_id: '3WnjfZxNIVr4abRZa3V3NkLznyUlFqk5'
    //   },
    //   headers: {
    //     'Accept': 'application/json',
    //     'Allow-Origin': '*/*',
    //   },
    // });
  }

  project = () => {
    return(
      <div></div>
    )
  }

  render(){
    return(
      <this.project />
    )
  }
}

ReactDOM.render(
  <Projects />,
  document.getElementById('archive')
);
