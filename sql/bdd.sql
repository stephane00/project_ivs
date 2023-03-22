-- Insérer des données dans la table "organisations"
INSERT INTO organisations (id, name)
VALUES
  (1, 'Organisation A'),
  (2, 'Organisation B'),
  (3, 'Organisation C');

-- Insérer des données dans la table "building"
INSERT INTO buildings (id, o_id_id, name, zipcode)
VALUES
  (1, 1, 'Building A', '12345'),
  (2, 2, 'Building B', '67890'),
  (3, 3, 'Building C', '11111'),
  (4, 3, 'Bâtiment X', '54321'),
  (5, 2, 'Bâtiment Y', '95000'),
  (6, 3, 'Bâtiment Z', '65850');

-- Insérer des données dans la table "pieces"
INSERT INTO pieces (id, b_id_id, name, people)
VALUES
  (1, 1, 'Piece A1', 2),
  (2, 1, 'Piece A2', 1),
  (3, 2, 'Piece B1', 1),
  (4, 2,'Piece B2', 1),
  (5, 3,'Piece C1', 0),
  (6, 3,'Piece C2', 2),
  (7, 1, 'Piece A3', 10),
  (8, 1, 'Piece B3', 20),
  (9, 2, 'Piece C3', 30),
  (10, 4, 'Piece A4', 10),
  (11, 5, 'Piece B4', 20),
  (12, 6, 'Piece C4', 30),
  (13, 6, 'Piece A5', 10),
  (14, 5, 'Piece B5', 20),
  (15, 4, 'Piece C5', 30);