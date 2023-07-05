import React, { useContext, useState } from 'react'
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';
import Footer from '../../components/FooterComponent';

const NewPlatform = () => {
  const [inputValue, setInputValue] = useState("");
  const { message, changeMessage} =useContext(MessageContext);
  const [selected, setSelected] = useState("");
  const navigate = useNavigate();


  const submitHandler = event => {
    changeMessage("");
    event.preventDefault();
    if (selected && inputValue !== "") {
      try {
        axios
          .post(`${endpoints.platform.post}`, { nombre: inputValue })
          .then(response => {
            changeMessage(response.data.mensaje);
          })
      } catch (error) {
        console.log(error);
      }


    };
    if (inputValue){
      navigate("/platforms");
    }
    else{
      changeMessage("No se obtuvo ningún nombre a modificar");
      alert(message);
    }

    
  }

  const changeHandler = event => {
    setInputValue(event.target.value);
  }

  return (
    <>
      <Header/>
      <NavBar/>
      <form className="Create-Form" onSubmit={ submitHandler }>
      <div className="Prueba">
        <p>Herramienta de agregado</p>
        <input type="text" placeholder="Nombre de la plataforma" onChange={ changeHandler } />
        <span>
          <button  onClick={() => { setSelected(true) }} ><IoIosCheckmark /></button>
          <button  onClick={() => { setSelected(false) }}><IoIosClose /></button>
        </span>
      </div>
      </form>
      <Footer/>
    </>
  )
}
export default NewPlatform;
