import React from 'react';
import '../../assets/css/generalStyles.css';
const Game = (props)=>{
  return(
    <>
      <div key={props.id} className='juegos'>
          <p>{props.nombre}</p>
          <br></br>
          <img src={`data:image/jpeg;base64, ${props.imagen}`} />
          <br></br>
          <p>{props.descripcion}</p>
        </div>
    </>
  )
}


export default Game;

