import React, { useContext, useState } from 'react'
import axios from 'axios';
import endpoints from '../../config/endpoints';
import {  useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';

const NewGender = ()=>{
  const { message,changeMessage} = useContext(MessageContext);
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
            changeMessage(response.data.mensaje);
          })
      } catch (error) {
        console.log(error);
      }
    }
    
    navigate("/genders");
  }

  const changeHandler = event =>{
    setInputValue(event.target.value)
  }

  return (
    <form className="Delete-Form"  onSubmit={submitHandler}>
      <p>Herramienta de agregado</p>
      
      <input type="text" placeholder="Nombre del genero" onChange={changeHandler}/>
      <span>
        <button onClick={() => { setSelected(true) }} ><IoIosCheckmark /></button>
        <button onClick={() => { setSelected(false) }}><IoIosClose/></button>

      </span>
    </form>
    )
  }
export default NewGender;
