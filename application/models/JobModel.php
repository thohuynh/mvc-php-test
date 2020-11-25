<?php

namespace Application\models;

class JobModel
{
    const STATUS_PLANNING = 1;
    const STATUS_DOING    = 2;
    const STATUS_COMPLETE = 3;

    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Get all jobs from database
     */
    public function getAllJobs()
    {
        $sql = "SELECT * FROM work.jobs";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // libs/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change libs/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Add a job to database
     * @param string $name
     * @param string $startTime
     * @param string $endTime
     */
    public function addJob($name, $startTime, $endTime)
    {
        // clean the input from javascript code for example
        $name      = strip_tags($name);
        $startTime = strip_tags($startTime);
        $endTime   = strip_tags($endTime);

        $sql   = "INSERT INTO work.jobs (name, status, start_time, end_time, created_at) VALUES (:name, :status, :start_time, :end_time, :created_at)";
        $query = $this->db->prepare($sql);
        $query->execute([
            ':name'       => $name,
            ':status'     => self::STATUS_PLANNING,
            ':start_time' => $startTime,
            ':end_time'   => $endTime,
            ':created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Delete a job in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $jobId Id of job
     */
    public function deleteJob($jobId)
    {
        $sql   = "DELETE FROM work.jobs WHERE jobs.id = :job_id";
        $query = $this->db->prepare($sql);
        $query->execute([':job_id' => $jobId]);
    }
}
