SELECT client.firstname AS  'clientFirst', client.lastname AS  'clientLast', client.billpayer, child.firstname AS  'childFirst', child.lastname AS 'childLast'
FROM  `client` AS client
LEFT JOIN  `client_has_child` AS cc ON client.id = cc.Client_id
LEFT JOIN  `child` AS child ON cc.Child_id = child.id
WHERE child.id IS NOT NULL AND client.id = (SELECT id FROM `client` WHERE firstname = 'Bob' AND lastname = 'Smith')
ORDER BY clientFirst ASC
LIMIT 0 , 30