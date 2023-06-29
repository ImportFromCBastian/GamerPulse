import React, { useState, useEffect, useContext } from 'react';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';
import Footer from '../../components/FooterComponent';
import { Link } from 'react-router-dom';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import PlatformRow from './PlatformRow';

import { IoIosAdd } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';

const PlatformListPage = () => {
  const { message,changeMessage } = useContext(MessageContext);
  const [platforms, setPlatforms] = useState(null);

  useEffect(() => {

    if(message) {
      alert(message);
      changeMessage("");
    }
    fetchPlatformData();
  }, [message]);


  

  const fetchPlatformData = async () => {
    try {
      const response = await axios
        .get(`${endpoints.platform.get}`);
      setPlatforms(response.data);

    } catch (error) {
      console.error(error);

    }
  }


  if (!platforms) return null;

  return (
    <>
      <Header />
      <NavBar />
      <div className="List">
        <Link className="Create-Button" to="/platforms/new_platform">
          <IoIosAdd className="Plus"/>
        </Link>
        {platforms.map(({ id, nombre }, index) =>
          <PlatformRow key={id} elem={{ id,nombre, index }}/>
        )}
      </div>
      <Footer />
    </>
  )
}

export default PlatformListPage;