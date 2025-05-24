# Job Portal Backend - Setup Guide

This guide will help you set up and run the Job Portal Backend project.

## Prerequisites

-   [Docker](https://www.docker.com/get-started)
-   [Docker Compose](https://docs.docker.com/compose/)

## 1. Clone the Repository

```bash
git clone https://github.com/your-username/Job-Portal-BackEnd.git
cd Job-Portal-BackEnd
```

## 2. Start the Application

Simply run:

```bash
docker compose up
```

This command will build and start all necessary services for the backend.

## 3. Access the Application

Once the containers are running, the backend should be accessible at `http://localhost:8000` (or the port specified in your `docker-compose.yml`).

## 4. Project Structure

```
Job-Portal-BackEnd/
├── src/
├── public/
├── docker-compose.yml
├── Dockerfile
└── README.md
```

## 5. Troubleshooting

-   Ensure Docker and Docker Compose are installed and running.
-   Check the logs with `docker compose logs` for any errors.
-   Make sure no other service is using the specified ports.

---

For further questions, open an issue or contact the maintainer.
