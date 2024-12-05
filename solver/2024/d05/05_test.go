package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedRules = rules{
		rule{47, 53},
		rule{97, 13},
		rule{97, 61},
		rule{97, 47},
		rule{75, 29},
		rule{61, 13},
		rule{75, 53},
		rule{29, 13},
		rule{97, 29},
		rule{53, 29},
		rule{61, 53},
		rule{97, 53},
		rule{61, 29},
		rule{47, 13},
		rule{75, 47},
		rule{97, 75},
		rule{47, 61},
		rule{75, 61},
		rule{47, 29},
		rule{75, 13},
		rule{53, 13},
	}
	parsedUpdates = updates{
		update{75, 47, 61, 53, 29},
		update{97, 61, 53, 29, 13},
		update{75, 29, 13},
		update{75, 97, 47, 61, 53},
		update{61, 13, 29},
		update{97, 13, 75, 29, 47},
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/05_example.txt")
	r, u := processInput(in)

	if !reflect.DeepEqual(r, parsedRules) {
		t.Errorf("processInput() - r: got %v, want %v", r, parsedRules)
	}
	if !reflect.DeepEqual(u, parsedUpdates) {
		t.Errorf("processInput() - u: got %v, want %v", u, parsedUpdates)
	}
}

func TestPartOne(t *testing.T) {
	expected := 143

	result, _ := partOne(parsedRules, parsedUpdates)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	// @todo
}
