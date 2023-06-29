import React, { useState , useEffect, useContext } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';

const GenderDelete = ()=>{
  const { id } = useParams("");
  const navigate = useNavigate();
  const { message,changeMessage  } = useContext(MessageContext);

  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.gender.fetch}${id}`)
        .then(response=>{
          changeMessage(`Seguro que desea borrar el elemento "${response.data.nombre}"`);
        });
        
    } catch (error) {
        console.log(error);
        
    }
  },[id])

  const clickCheckMarkHandler = () => {

    axios
      .delete(`${endpoints.gender.delete}${id}`, { header: ('Access-Control-Allow-Origin', '*') })
      .then(response =>{
        changeMessage(response.data.mensaje);
      })
      navigate("/genders");

  }
  const clickCloseMarkHandler = ()=>{ 
    changeMessage("No se borro genero");
    navigate("/genders");
  }
  return(
    <div>
      <p>{ message } </p>
      <div>
        <button onClick={ clickCheckMarkHandler }><IoIosCheckmark/></button>
        <button onClick={ clickCloseMarkHandler }><IoIosClose/></button>
      </div>
    </div>
  )
}
export default GenderDelete;