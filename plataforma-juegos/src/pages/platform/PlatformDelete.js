import React, { useState, useEffect } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';


const PlatformDelete = () => {
  const { id } = useParams("");
  const [message, setMessage] = useState("");
  const [platformName, setPlatformName] = useState("");
  const navigate = useNavigate();


  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.platform.fetch}${id}`)
        .then(response=>{
          setPlatformName(response.data.nombre);

        });
    } catch (error) {
      console.log(error);
    }
    setMessage(`Seguro borrar el elemento ${platformName}`);
  },[id]);
  const clickCheckMarkHandler = () => {

    axios
      .delete(`${endpoints.platform.delete}${id}`, { header: ('Access-Control-Allow-Origin', '*') })
      .then(response => {
        setMessage(response.data.mensaje);
      })
    navigate("/platforms");

  }
  const clickCloseMarkHandler = () => {
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
