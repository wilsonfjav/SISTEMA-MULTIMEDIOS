// src/components/Buttons.jsx
import { useNavigate } from "react-router-dom";

export const VolverButton = () => {
  const navigate = useNavigate();

  return (
    <button onClick={() => navigate("/")}>
      Volver
    </button>
  );
};
