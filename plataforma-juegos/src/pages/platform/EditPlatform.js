import React, { useState, useEffect } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';

const EditPlatform = () => {

  const { id } = useParams("");
  const [inputValue, setInputValue] = useState();
  const [selected, setSelected] = useState("")
  const [message, setMessage] = useState("");
  const navigate = useNavigate();

  useEffect(()=>{
    try{
      axios
        .get(`${endpoints.platform.fetch}${id}`)
        .then(response=>{
          setInputValue(response.data.nombre);
          setMessage(`Modificando el elemento "${response.data.nombre}"`);
          
        })
    }catch(error){
      console.log(error);
        
    }
  },[id])

  const submitHandler = event => {
    event.preventDefault();
    if (selected && inputValue !== "") {
      try {
        axios
          .put(`${endpoints.platform.put}${id}`, { nombre: inputValue })
          .then(response => {
            setMessage(response.data.mensaje);

          });

      } catch (error) {
        console.log(error);
      }


    } else {
      setMessage("No se actualizo la plataforma");
    }
    navigate("/platforms");
  }

  const changeHandler = event => {
    setInputValue(event.target.value);
  }

  return (
    <div>
      <p>{ message }</p>
      <form onSubmit={ submitHandler }>
        <input type="text" value={ inputValue } onChange={ changeHandler } />
        <div className="Submit-Buttons">
          <button onClick={() => { setSelected(true) }}>  <IoIosCheckmark /> </button>
          <button onClick={() => { setSelected(false) }}> <IoIosClose />     </button>
        </div>
      </form>
    </div>
  )
}

export default EditPlatform;
