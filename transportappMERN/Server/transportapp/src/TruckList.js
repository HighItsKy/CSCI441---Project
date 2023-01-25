import TruckItem from './TruckItem';

const TruckList = ({ truckJobs }) => {
    return (
        <table className={"table table-sm table-striped"}>
            <colgroup>
                <col style={{width:'10%'}}></col>
                <col style={{width:'20%'}}></col>
                <col style={{width:'30%'}}></col>
                <col style={{width:'30%'}}></col>
                <col style={{width:'10%'}}></col>
            </colgroup>
            <tbody>
                {truckJobs.map((truckJob) => (
                    <TruckItem
                        key = {truckJob.ID}
                        truckJob = {truckJob}                    
                    />
                ))}
            </tbody>
        </table>
    )
}

export default TruckList
