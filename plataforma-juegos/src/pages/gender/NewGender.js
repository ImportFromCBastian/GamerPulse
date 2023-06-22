import React, { useState } from 'react'
import axios from 'axios';
import endpoints from '../../config/endpoints';
import {  useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';

const NewGender = ()=>{
  const [message,setMessage] = useState("Herramienta de Agregado");
  const [inputValue, setInputValue] = useState("");
  const [selected,setSelected] = useState("");
  const navigate = useNavigate();

  const submitHandler = event =>{
    event.preventDefault();
    if(selected && inputValue !== ""){
      try {
        axios
          .post(`${endpoints.gender.post}`,{ nombre: inputValue})
          .then(response =>{
            setMessage(response.data.mensaje);
          })
      } catch (error) {
        console.log(error);
      }
      navigate("/genders");
      
    }else{
      navigate("/genders");
    }
  }

  const changeHandler = event =>{
    setInputValue(event.target.value)
  }

  return (
    <form onSubmit={submitHandler}>
      <p>{message}</p>
      <input type="text" placeholder="Nombre del genero" onChange={changeHandler}/>
      <button onClick={() => { setSelected(true) }} ><IoIosCheckmark /></button>
      <button onClick={() => { setSelected(false) }}><IoIosClose/></button>
    </form>
    )
  }
export default NewGender;
