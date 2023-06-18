import React,{useState, useEffect} from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import Header from '../../components/HeaderComponent';
import Footer from '../../components/FooterComponent';
import NavBar from '../../components/NavBarComponent';
import GenderRow from './GenderRow';
import { IoIosCreate } from 'react-icons/io';
import { Link } from 'react-router-dom';

const GenderListPage = () =>{
  
  const [gender, setGender] = useState(null);

  useEffect(() => {
    fetchGenderData();
  },[]);

  const fetchGenderData = async () =>{
    try {
     const response = await axios
        .get(`${endpoints.gender.get}`);
        setGender(response.data);

    } catch (error) {
      console.error(error);

    }
  }
  
  
  if(!gender) return null;
  
  return(
    <>
      <Header/>
      <NavBar/>
      <Link to="/genders/new_gender">
        <button> <IoIosCreate/> </button>
      </Link>
      <div className="List">
        {gender.map(({id,nombre},index)=>
          <GenderRow key={id} elem={{nombre,index,id}}/>
        )}
      </div>
      <Footer/>
    </>
  ) 
}

export default GenderListPage;