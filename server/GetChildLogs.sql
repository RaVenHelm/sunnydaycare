SELECT `id`, `Day`, `CheckIn`, `CheckOut`, `Child_id` FROM `log` 
WHERE `Child_id` = 1 AND `Day`>= '2015-04-01' AND `Day` <= '2015-05-06'
ORDER BY `Day` ASC;