
const TruckItem = ({ truckJob }) => {
    return (   
        <tr>
        <td>
            <button className={"btn btn-outline-primary"}>
            {truckJob.ID}        
            </button>
        </td>            
        <td>
            {truckJob.TransportDate}
        </td>
        <td>
            [{truckJob.TransportFrom}]
        </td>
        <td>
            [{truckJob.TransportTo}]
        </td>
        <td> 
            {truckJob.Completed === '1'? "[Completed]" : "[Pending]"}
        </td>
        </tr>
    )
}

export default TruckItem
