import React,{Component} from 'react';

import './styles.scss';

import Header from '../../_common/header';
import Menu from '../../_common/menu';

import api from '../../../services/api';

class Upload extends Component { 

	state = { 
  	selectedFile: []
	}; 

	onFileChange = event => { 
    this.setState({ selectedFile: event.target.files[0] }); 
    console.log(this.state);
  }; 
  
	onFileUpload = () => { 

    const data = new FormData(); 
    
    data.append( 
      "files[]", 
      this.state.selectedFile, 
      this.state.selectedFile.name 
    ); 
  
    console.log(data); 
  
    try{
      api.post('http://127.0.0.1:8000/api/upload', data);

    }catch(err){
      alert(err);
    }

  }; 
	
	render() { 
    return ( 
      <div className="container">
      <Header />
      <Menu />
      <div className="main">
        <div> 
            <input type="file" onChange={this.onFileChange} multiple/> <br></br>
            <input type="submit" onClick={this.onFileUpload}/>
          </div> 
      </div>
    </div>
    ); 
	} 
} 

export default Upload; 
