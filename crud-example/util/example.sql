--
-- Generate data for table `CustomerList`
--
INSERT INTO `CustomerList` (`CustomerID`, `FirstName`, `LastName`, `Email`, `PhoneNumber`, `Address`, `City`, `State`) VALUES
(1, 'Mickey', 'Mouse', 'mickey.mouse@example.com', '202-555-0100', '555 Example St', 'Example City', 'CT'),
(2, 'Donald', 'Duck', 'donald.duck@example.com', '202-555-0105', '543 Foo St', 'Foo City', 'AZ'),
(3, 'Minnie', 'Mouse', 'minnie.mouse@example.com', '202-555-0106', '744 Bar St', 'Example City', 'TX'),
(4, 'Bob', 'Barker', 'bob.barker@example.com', '202-555-0102', '1235 Foo Ave', 'Bar City', 'AZ'),
(5, 'Clark', 'Kent', 'clark.kent@example.com', '202-555-0104', '7522 Example St', 'Foo City', 'AL'),
(6, 'Mick', 'Jagger', 'mick.jagger@example.com', '202-555-0103', '19 Bar Ave', 'Example City', 'CT'),
(7, 'Bobbie', 'Flay', 'bobbie.flay@example.com', '202-555-0183', '1286 Bar St', 'Example City', 'AL'),
(8, 'Bruce', 'Wayne', 'bruce.wayne@example.com', '202-555-0199', '1221 Example St', 'Foo City', 'AK'),
(9, 'Diana', 'Prince', 'diana.prince@example.com', '202-555-0110', '908 Example Ave', 'Bar City', 'TX'),
(10, 'Daffy', 'Duck', 'daffy.duck@example.com', '202-555-0132', '643 Example Ave', 'Bar City', 'FL'),
(11, 'Bugs', 'Bunny', 'bugs.bunny@example.com', '202-555-0173', '53 Foo Ave', 'Example City', 'FL');
--
-- Generate data for table `CustomerNotes`
--
INSERT INTO `CustomerNotes` (`NoteID`, `Note`, `CustomerID`) VALUES
(1, 'Really dislikes Daffy Duck.', 2),
(2, 'Do not mention parents around him.', 8),
(3, 'Reach out to Mickey for further details.', 3),
(4, 'Pretty super guy.', 5),
(5, '', 1),
(6, 'He needs a doc.', 11);