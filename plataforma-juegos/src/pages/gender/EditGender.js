import { useState, useEffect, useContext } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';
import Footer from '../../components/FooterComponent';


const EditGender = () => {
  const { message,changeMessage } = useContext(MessageContext);
  const { id } = useParams("");
  const [ inputValue,setInputValue ] = useState("");
  const [selected, setSelected] = useState("");
  const navigate = useNavigate();
  const [initialState, setInitialState] = useState("");
  

  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.gender.fetch}${id}`)
        .then(response =>{
          setInitialState(`Modificando el elemento "${response.data.nombre}"`);
          setInputValue(response.data.nombre);
          
        })
    } catch (error) {
      console.log(error);
    };
  },[id]);


  useEffect(() => {
    if (message) alert(message);
    changeMessage("");
  }, [message]);

  const submitHandler = event => {
    changeMessage("");
    event.preventDefault();
    if(selected && inputValue !== ""){
      try{
        axios
          .put(`${endpoints.gender.put}${id}`, { nombre: inputValue }, { header: ('Access-Control-Allow-Origin', '*') })
          .then(response => {
            changeMessage(response.data.mensaje);
          });

      }catch(error){
        console.log(error);
      }
      navigate("/genders");
      
    }
    
    if (inputValue === "" && selected) {
      changeMessage("El nombre del genero a modificar no puede ser vacio");


    }else{

      if (!selected) {
        changeMessage("No se obtuvo ningún nombre a modificar");
        navigate("/genders");
        
      }
    }

    
    
    
  }

  const changeHandler = event =>{
    setInputValue(event.target.value);
  }

  return (
    <>
      <Header/>
      <NavBar/>
        <div className="Create-Form">
          <form className="Prueba" onSubmit={ submitHandler }>
            <p>{ initialState }</p>
            <input type="text" value={ inputValue } onChange={ changeHandler } />
            <div className="Submit-Buttons">
              <button onClick={() => { setSelected(true) }}>  <IoIosCheckmark /> </button>
              <button onClick={() => { setSelected(false) }}> <IoIosClose />     </button>
            </div>
          </form>
        </div>
      <Footer/>
    </>
  )
}

export default EditGender;