import React, { useState } from 'react'
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';

const NewPlatform = () => {
  const [message, setMessage] = useState("Herramienta de Agregado");
  const [inputValue, setInputValue] = useState("");
  const [selected, setSelected] = useState("");
  const navigate = useNavigate();

  const submitHandler = event => {
    event.preventDefault();
    if (selected && inputValue !== "") {
      try {
        axios
          .post(`${endpoints.platform.post}`, { nombre: inputValue })
          .then(response => {
            setMessage(response.data.mensaje);
          })
      } catch (error) {
        console.log(error);
      }

      navigate("/platforms");

    } else {
      navigate("/platforms");

    }
  }

  const changeHandler = event => {
    setInputValue(event.target.inputValue);
  }

  return (
    <form onSubmit={submitHandler}>
      <p>{ message }</p>
      <input type="text" placeholder="Nombre de la plataforma" onChange={ changeHandler } />
      <button onClick={() => { setSelected(true) }} ><IoIosCheckmark /></button>
      <button onClick={() => { setSelected(false) }}><IoIosClose /></button>
    </form>
  )
}
export default NewPlatform;
