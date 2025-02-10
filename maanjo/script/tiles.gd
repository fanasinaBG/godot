extends TileMap

func _ready() -> void:
	var tile_source = tile_set.atlas_sources[0]
	var tile_position = Vector2i(2, 2)
	var tile_pos = Vector2i(1, 0)
	
	if tile_source.has_tile(tile_pos):
		set_cell(tile_position, tile_source.get_tile_id(tile_pos))
