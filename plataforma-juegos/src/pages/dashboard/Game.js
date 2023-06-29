import React from 'react';
import '../../assets/css/generalStyles.css';


const Game = (props)=>{
  return(
    <>
      <div key={props.elem.id} className='juegos'>
          <p>{props.elem.nombre}</p>
          <br></br>
          <img src={`data:${props.elem.tipo_imagen};base64, ${props.elem.imagen}`} />
          <br></br>
          <p>{props.elem.descripcion}</p>
        </div>
    </>
  )
}


export default Game;

