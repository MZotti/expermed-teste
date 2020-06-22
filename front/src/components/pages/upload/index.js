import React,{Component} from 'react';

import './styles.scss';

import Header from '../../_common/header';
import Menu from '../../_common/menu';

import api from '../../../services/api';

class Upload extends Component { 

	state = { 
    selectedFile: [],
    message: ''
	}; 

	onFileChange = event => { 
    this.setState({ selectedFile: event.target.files[0] });
  }; 
  
	  onFileUpload = async () => { 

    this.setState({ message: '' });

    const data = new FormData(); 
    
    data.append( 
      "files[]", 
      this.state.selectedFile
    ); 
  
    console.log(data); 
  
    try{
      const response = await api.post('http://127.0.0.1:8000/api/upload', data);
      this.setState({ message: 'Arquivo enviado!' });
    }catch(err){
      console.log(err);
      this.setState({ message: 'Ocorreu um erro ao enviar o arquivo!' });
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
        <span>{this.state.message}</span>
      </div>
    </div>
    ); 
	} 
} 

export default Upload; 
