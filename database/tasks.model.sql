CREATE TABLE IF NOT EXISTS tasks(  
    id SERIAL PRIMARY KEY,
    project_id INTEGER NOT NULL REFERENCES projects (id),
    assigned_to INTEGER REFERENCES users (id),
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status VARCHAR(20) DEFAULT 'pending',
    due_date DATE
);