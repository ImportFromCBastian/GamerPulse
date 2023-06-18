import React from 'react';
import Header from '../../components/HeaderComponent'
import Footer from '../../components/FooterComponent';
import NavBar from '../../components/NavBarComponent'


const DashboardPage = () => {
  return(
    <div>
      <Header/>
      <NavBar/>
      <form method="get">
        <input type="text" placeholder="Texto de ejemplo"/>
        <input type="text" placeholder="Texto de ejemplo"/>
        <input type="text" placeholder="Texto de ejemplo"/>
      </form>
      <Footer/>
    </div>
  )
}

export default DashboardPage;