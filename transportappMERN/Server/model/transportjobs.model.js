const sql = require("./db.js");

// constructor
class TransportJob {
    constructor(transportJob) {
        (this.ID = transportJob.ID),
        (this.TransportDate = transportJob.TransportDate),
        //reciever
        (this.TransportTo = transportJob.TransportTo),
        (this.TransportToAddress = transportJob.TransportToAddress),
        (this.TransportToCityStateZip =
            transportJob.TransportToCityStateZip),
        (this.TransportToPhone = transportJob.TransportToPhone),
        //shipper
        (this.TransportFrom = transportJob.TransportFrom),
        (this.TransportFromAddress = transportJob.TransportFromAddress),
        (this.TransportFromCityStateZip =
            transportJob.TransportFromCityStateZip),
        (this.TransportFromPhone = transportJob.TransportFromPhone),
        //Car1
        (this.Car1Year = transportJob.Car1Year),
        (this.Car1Make = transportJob.Car1Make),
        (this.Car1Model = transportJob.Car1Model),
        (this.Car1Color = transportJob.Car1Color),
        (this.Car1Serial = transportJob.Car1Serial),
        (this.Car1Stock = transportJob.Car1Stock),
        (this.Car1Price = transportJob.Car1Price),
        (this.Car1Img = transportJob.Car1Img),
        //car2
        (this.Car2Year = transportJob.Car2Year),
        (this.Car2Make = transportJob.Car2Make),
        (this.Car2Model = transportJob.Car2Model),
        (this.Car2Color = transportJob.Car2Color),
        (this.Car2Serial = transportJob.Car2Serial),
        (this.Car2Stock = transportJob.Car2Stock),
        (this.Car2Price = transportJob.Car2Price),
        (this.Car2Img = transportJob.Car2Img),
        //Car3
        (this.Car3Year = transportJob.Car3Year),
        (this.Car3Make = transportJob.Car3Make),
        (this.Car3Model = transportJob.Car3Model),
        (this.Car3Color = transportJob.Car3Color),
        (this.Car3Serial = transportJob.Car3Serial),
        (this.Car3Stock = transportJob.Car3Stock),
        (this.Car3Price = transportJob.Car3Price),
        (this.Car3Img = transportJob.Car3Img),
        //car4
        (this.Car4Year = transportJob.Car4Year),
        (this.Car4Make = transportJob.Car4Make),
        (this.Car4Model = transportJob.Car4Model),
        (this.Car4Color = transportJob.Car4Color),
        (this.Car4Serial = transportJob.Car4Serial),
        (this.Car4Stock = transportJob.Car4Stock),
        (this.Car4Price = transportJob.Car4Price),
        (this.Car4Img = transportJob.Car4Img),
        //car5
        (this.Car5Year = transportJob.Car5Year),
        (this.Car5Make = transportJob.Car5Make),
        (this.Car5Model = transportJob.Car5Model),
        (this.Car5Color = transportJob.Car5Color),
        (this.Car5Serial = transportJob.Car5Serial),
        (this.Car5Stock = transportJob.Car5Stock),
        (this.Car5Price = transportJob.Car5Price),
        (this.Car5Img = transportJob.Car5Img),
        //car6
        (this.Car6Year = transportJob.Car6Year),
        (this.Car6Make = transportJob.Car6Make),
        (this.Car6Model = transportJob.Car6Model),
        (this.Car6Color = transportJob.Car6Color),
        (this.Car6Serial = transportJob.Car6Serial),
        (this.Car6Stock = transportJob.Car6Stock),
        (this.Car6Price = transportJob.Car6Price),
        (this.Car6Img = transportJob.Car16mg),
        (this.Completed = transportJob.Completed),
        (this.DriverImg = transportJob.DriverImg),
        (this.driverUser = transportJob.driverUser),
        (this.ReceiverDate = transportJob.ReceiverDate),
        (this.ReceiverImg = transportJob.ReceiverImg),
        (this.ShipperDate = transportJob.ShipperDate),
        (this.ShipperImg = transportJob.ShipperImg)
    }

    static create(newJob, result) {
        let sqlString = "INSERT INTO `TransportJobs` ( `ID`";
        let sqlString2 = " VALUES ( NULL";

        for (const key in newJob) {
            if (newJob[key] && key != "Completed" && key != "ID") {
                sqlString += ", `" + key + "`";
                sqlString2 += ", " + sql.escape(newJob[key]);
            }
        }
        sqlString += ", `Completed` )";
        sqlString2 += ", FALSE )";

        sqlString += sqlString2;

        sql.query(sqlString, (err, res) => {
            if (err) {
                console.log("Error: ", err);
                result(err, null);
                return;
            }
            result(null, {
                ID: res.insertId,
            });
        });
    }

    static findById(jobId, result) {
        console.log(jobId);
        sql.query(
            `SELECT * FROM TransportJobs WHERE ID = ?`,
            jobId,
            (err, res) => {
                if (err) {
                    console.log("error: ", err);
                    result(err, null);
                    return;
                }
                if (res.length) {
                    result(null, res[0]);
                    return;
                }
                // not found Property with the id
                result(
                    {
                        kind: "not_found",
                    },
                    null
                );
            }
        );
    }
    static getAll(result) {
        sql.query(
            "SELECT ID, TransportDate, TransportTo, TransportFrom, Car1Serial, Car1Stock, Car2Serial, Car2Stock, Car3Serial, Car3Stock, Car4Serial, Car4Stock, Car5Serial, Car5Stock, Car6Serial, Car6Stock, Completed FROM TransportJobs ORDER BY ID DESC",
            (err, res) => {
                if (err) {
                    console.log("error: ", err);
                    result(null, err);
                    return;
                }
                result(null, res);
            }
        );
    }

    static updateById(transportJob, result) {
        let sqlString = "UPDATE `TransportJobs` SET ";
        let flag = 0;

        for (const key in transportJob) {
            if (transportJob[key] && key != "ID") {
                if (flag === 0) {
                    flag = 1;
                } else {
                    sqlString += " , ";
                }
                sqlString += "`" + key + "` = " + sql.escape(transportJob[key]);
            }
        }

        sqlString += " WHERE `ID` = " + sql.escape(transportJob.ID);

        sql.query(sqlString, (err, res) => {
            if (err) {
                console.log("error: ", err);
                result(null, err);
                return;
            }
            if (res.affectedRows == 0) {
                // not found Property with the id
                result(
                    {
                        kind: "not_found",
                    },
                    null
                );
                return;
            }
            result(null, {
                ID: transportJob.ID,
            });
        });
    }
    static remove(id, result) {
        /*
    Not implemented at this time
    sql.query("DELETE FROM properties WHERE id = ?", id, (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      if (res.affectedRows == 0) {
        // not found Property with the id
        result({ kind: "not_found" }, null);
        return;
      }
      console.log("deleted property with id: ", id);
      result(null, res);
    });
    */
    }
}

module.exports = TransportJob;
