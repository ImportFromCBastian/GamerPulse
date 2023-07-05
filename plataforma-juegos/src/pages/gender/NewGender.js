import React, { useContext, useEffect, useState } from 'react'
import axios from 'axios';
import endpoints from '../../config/endpoints';
import {  useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';
import Footer from '../../components/FooterComponent';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';

const NewGender = ()=>{
  const { message,changeMessage} = useContext(MessageContext);
  const [inputValue, setInputValue] = useState("");
  const [selected,setSelected] = useState("");
  const navigate = useNavigate();
  
  useEffect(() => {
    if (message) alert(message);
    changeMessage("");
  }, [message]);


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
      navigate("/genders")
    }
    
    if (inputValue === "" && selected) {
      changeMessage("El nombre del genero no puede ser vacio");


    } else {
      if (!selected) {
        changeMessage("No se obtuvo un genero para agregar");
        navigate("/genders");
      }
    }
  }

  const changeHandler = event =>{
    setInputValue(event.target.value)
  }

  return (
    <>
      <Header/>
      <NavBar/>
      <form className="Create-Form"  onSubmit={submitHandler}>
        <div className="Prueba">
          <p>Herramienta de agregado</p>
          
          <input className="Create-Item"  type="text" placeholder="Nombre del genero" onChange={changeHandler}/>
          <span>
            <button className="Create-Item" onClick={() => { setSelected(true) }} ><IoIosCheckmark /></button>
            <button className="Create-Item" onClick={() => { setSelected(false) }}><IoIosClose/></button>

          </span>

        </div>
      </form>
      <Footer/>
    </>
    )
  }
export default NewGender;
