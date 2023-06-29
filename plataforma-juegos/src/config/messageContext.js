import React , { createContext , useState } from 'react';

export const MessageContext = createContext();

export const MessageProvider = ({ children }) => {
  const [message, setMessage] = useState("");
  const changeMessage = newMessage => {
    setMessage(newMessage);
  }

  return (
    <MessageContext.Provider value={{message,changeMessage}}>
      {children}
    </MessageContext.Provider>
  )
}