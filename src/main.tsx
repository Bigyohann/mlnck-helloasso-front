import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './App.tsx'

createRoot(document.getElementById('mlnck_helloasso')!).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
