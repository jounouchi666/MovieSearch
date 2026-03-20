import { Routes, Route } from "react-router-dom"
import { Search } from "./pages/Search"

function App() {
  return (
    <Routes>
      <Route path="/" element={<Search />}/>
    </Routes>
  )
}

export default App
