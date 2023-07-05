import React, { useEffect, useState } from 'react';
import '../../assets/css/generalStyles.css';


const Game = (props)=>{

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
          <p>{props.elem.nomPlat}</p>
          <br></br>
          <p>{props.elem.nomGen}</p>
        </div>
    </>
  )
}


export default Game;

