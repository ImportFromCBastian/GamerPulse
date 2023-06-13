const endpoints = {
  genre: {
    get:"http://localhost:8000/GamerPulse/genders",
    post:"http://localhost:8000/GamerPulse/genders",
    put:"http://localhost:8000/GamerPulse/genders/",
    delete:"http://localhost:8000/GamerPulse/genders/"
  },

  platform: {
    get:"http://localhost:8000/GamerPulse/plataformas",
    post:"http://localhost:8000/GamerPulse/plataformas",
    put:"http://localhost:8000/GamerPulse/plataformas/",
    delete:"http://localhost:8000/GamerPulse/plataformas/"
  },

  games: {
    get:"http://localhost:8000/GamerPulse/games",
    post:"http://localhost:8000/GamerPulse/games",
    put:"http://localhost:8000/GamerPulse/games/",
    delete:"http://localhost:8000/GamerPulse/games/"
  }
}

export default endpoints;