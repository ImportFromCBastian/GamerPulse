import React, { useState } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';

const EditPlatform = () => {

  const { id, name } = useParams("");
  const navigate = useNavigate();
  const [inputValue, setInputValue] = useState(name);
  const [selected, setSelected] = useState("")
  const [message, setMessage] = useState(`Modificando elemento ${name}`);

  const submitHandler = event => {
    event.preventDefault();
    if (selected && inputValue !== "") {
      try {
        axios
          .put(`${endpoints.platform.put}/${id}`, { nombre: inputValue })
          .then(response => {
            setMessage("Mensaje devuelto por api");
          });

      } catch (error) {
        console.log(error);
      }

      navigate("/platforms");

    } else {
      navigate("/platforms");

    }
  }

  const changeHandler = event => {
    setInputValue(event.target.value);
  }

  return (
    <div>
      <p>{message}</p>
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
