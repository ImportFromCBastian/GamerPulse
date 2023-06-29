import React, { useEffect, useState } from 'react';
import '../../assets/css/generalStyles.css';
import axios from 'axios';
import endpoints from '../../config/endpoints';



const Game = (props)=>{

  const [responseGender,setResponseGender] = useState();
  const [responsePlatform,setResponsePlatform] = useState();

  useEffect(() =>{
    const buscar=async (id_genero,id_plataforma)=>{
      try{
        let fetchGender = await axios.get(`${endpoints.gender.fetch}${id_genero}`);
        let fetchPlatform = await axios.get(`${endpoints.platform.fetch}${id_plataforma}`);
        setResponseGender(fetchGender.data.nombre);
        setResponsePlatform(fetchPlatform.data.nombre);
      }catch(e){
        console.log(e);
      }
    }
    buscar(props.elem.id_genero,props.elem.id_plataforma);
  },[]);

  return(
    <>
      <div key={props.elem.id} className='juegos'>
          <p>{props.elem.nombre}</p>
          <br></br>
          <a href={props.elem.url} target='_blank'>
            <img src={`data:${props.elem.tipo_imagen};base64, ${props.elem.imagen}`}/>
          </a>
          <br></br>
          <p>{props.elem.descripcion}</p>
          <br></br>
          <p>{responseGender}</p>
          <br></br>
          <p>{responsePlatform}</p>
        </div>
    </>
  )
}


export default Game;

