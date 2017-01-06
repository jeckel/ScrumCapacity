## Definitions
- **Scrum**
- **Member**
- **Sprint**
- **Capacity**
- **Availability**
- **Efficiency**
- **Sprint target**
- **Points**

## Data models

Sprint :
- **Members** : List of team members working on this sprint 
- **nb_days** : Number of working days in the sprint
- **capacity** : Nb of man days available for this sprint

Member :
- Name

Sprint / Member :
- **nb_days_presence** : (0 <= x <= sprint.nb_days)
- **availability** : (0 <= x <= 1)

## Formula

- Member capacity for a sprint : `capacity = nb_days_presence * availibility`
- Sprint capacity : `sprint.capacity = SUM(member.capacity)`
- Sprint efficiency : `sprint.efficiency = nb_points_done / sp_capacity`
- Sprint total capacity : capacity total since the beginning of the project until this sprint
- Average efficiency : `sprint.average_efficiency = SUM(sprint(#0-n).nb_points_done) / SUM (sprint(#0-n).capacity)`
- Sprint target : `target = sp_capacity * (sprint N-1).average_efficiency`

