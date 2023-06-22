import React, { useState } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';


const PlatformDelete = () => {
  const { id, name } = useParams("");
  const [message, setMessage] = useState(`Desea borrar el elemento ${name}?`);
  const navigate = useNavigate();

  const clickCheckMarkHandler = () => {

    axios
      .delete(`${endpoints.platform.delete}/${id}`, { header: ('Access-Control-Allow-Origin', '*') })
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
