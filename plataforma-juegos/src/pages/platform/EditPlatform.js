import { useState, useEffect, useContext } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';
import Footer from '../../components/FooterComponent';

// Tira warning sin sentido, porque es lo mismo que el componente EditGender 

const EditPlatform = () => {
  const { message,changeMessage } = useContext(MessageContext);
  const { id } = useParams("");
  const [inputValue, setInputValue] = useState();
  const [selected, setSelected] = useState("")
  const navigate = useNavigate();

  useEffect(()=>{
    try{
      axios
        .get(`${endpoints.platform.fetch}${id}`)
        .then(response=>{
          setInputValue(response.data.nombre);
          changeMessage(`Modificando el elemento "${response.data.nombre}"`);
          
        })
    }catch(error){
      console.log(error);
        
    };
  },[id])

  const submitHandler = event => {
    changeMessage("");
    event.preventDefault();
    if (selected && inputValue !== "") {
      try {
        axios
          .put(`${endpoints.platform.put}${id}`, { nombre: inputValue })
          .then(response => {
            changeMessage(response.data.mensaje);

          });

      } catch (error) {
        console.log(error);
      }


    } else {
      changeMessage("No se actualizo la plataforma");
    }
    navigate("/platforms");
  }

  const changeHandler = event => {
    setInputValue(event.target.value);
  }

  return (
    <>
      <Header />
      <NavBar />
      <div className="Create-Form">
        <form className="Prueba" onSubmit={submitHandler}>
          <p>{message}</p>
          <input type="text" value={inputValue} onChange={changeHandler} />
          <div className="Submit-Buttons">
            <button onClick={() => { setSelected(true) }}>  <IoIosCheckmark /> </button>
            <button onClick={() => { setSelected(false) }}> <IoIosClose />     </button>
          </div>
        </form>
      </div>
      <Footer />
    </>
  )
}

export default EditPlatform;
