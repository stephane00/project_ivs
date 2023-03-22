import React, { useState, useEffect } from 'react';
import axios from "axios";

function PiecesComponent() {
    const [data, setData] = useState(null);

    useEffect(() => {
        const fetchData = async () => {
            const result = await axios.get(`${window.location.pathname}JSON`);
            setData(result.data);
        };
        fetchData();
    }, []);
    return (
        <div>
            {data ? (
                <div>
                    <div>
                        <h2>List of Room in this building - {data[0].nameBuilding}  :</h2>
                    </div>
                    {data.map((item) => (
                        <div key={item.id}>
                            <ul>
                                <li>{item.name}</li>
                                <p>nombre totale de personne présente dans la piece {item.people}</p>
                            </ul>
                        </div>
                    ))}
                </div>
            ) :  (
                <p>Loading...</p>
            )}
        </div>
    );
}

export default PiecesComponent;