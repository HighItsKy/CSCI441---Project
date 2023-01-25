import Header from './Header.js';
import Nav from './Nav.js';
import Content from './Content.js';
import { useState, useEffect } from 'react';

function App() {
    const [truckJobs, setTruckJobs] = useState([]);
    const API_URL = 'http://127.0.0.1:3500/TransportApp/TransportData';


    useEffect(() => {

        const fetchItems = async () => {
          try {
            const response = await fetch(API_URL);
                if (!response.ok) throw Error('Did not receive expected data');
            const listItems = await response.json();
            setTruckJobs(listItems);
          } catch (err) {
              console.log(err);
          }
        }  
                
        fetchItems();

    }, [])


    return (
    <div className={"App container"}>
        <Header />
        <Nav />
        <Content 
            truckJobs = {truckJobs}
        />
    </div>
  );
}

export default App;
