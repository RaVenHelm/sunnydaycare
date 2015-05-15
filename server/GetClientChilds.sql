SELECT client.id AS 'ClientId', client.firstname AS  'clientFirst', client.lastname AS 'clientLast', child.id as 'ChildId', child.firstname AS  'childFirst', child.lastname AS 'childLast'
FROM  `client` AS client
LEFT JOIN  `client_has_child` AS cc ON client.id = cc.Client_id
LEFT JOIN  `child` AS child ON cc.Child_id = child.id
WHERE `cc`.Child_id IS NOT NULL AND client.billpayer = TRUE AND client.firstname = 'Mary' AND client.lastname = 'Smith'
ORDER BY clientFirst ASC;