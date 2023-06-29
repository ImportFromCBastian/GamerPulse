import React, { useState, useEffect, useContext } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';

const PlatformDelete = () => {

  const { message , changeMessage} = useContext(MessageContext);
  const { id } = useParams("");
  const [platformName, setPlatformName] = useState("");
  const navigate = useNavigate();


  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.platform.fetch}${id}`)
        .then(response=>{
          setPlatformName(response.data.nombre);
          changeMessage(`Seguro borrar el elemento ${response.data.nombre}`);

        });
    } catch (error) {
      console.log(error);
    }
  },[id]);


  const clickCheckMarkHandler = () => {

    axios
      .delete(`${endpoints.platform.delete}${id}`, { header: ('Access-Control-Allow-Origin', '*') })
      .then(response => {
        changeMessage(response.data.mensaje);
      })
    navigate("/platforms");

  }
  const clickCloseMarkHandler = () => {
    changeMessage("No se borro platforma");
    navigate("/platforms");
  }
  return (
    <div>
      <p>{ message }</p>
      <div>
        <button onClick={ clickCheckMarkHandler }><IoIosCheckmark /></button>
        <button onClick={ clickCloseMarkHandler }><IoIosClose /></button>
      </div>
    </div>
  )
}

export default PlatformDelete;
