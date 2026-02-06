import { useState, useEffect } from "react";
import NodeWrapper from "./NodeWrapper.jsx";
import { Position } from "reactflow";

export default function SendMultiProductNode({ id, data, setNodes }) {
    const handles = [{ type: "target", position: Position.Left }];
    const [header, setHeader] = useState(data.header || "");
    const [body, setBody] = useState(data.body || "");
    const [footer, setFooter] = useState(data.footer || "");
    const [catalogId, setCatalogId] = useState(data.catalog_id || "");

    // sections structure: [{ title: "", product_items: [{ product_retailer_id: "" }] }]
    const [sections, setSections] = useState(data.sections || [{ title: "Section 1", product_items: [{ product_retailer_id: "" }] }]);

    useEffect(() => {
        setNodes((nds) =>
            nds.map((node) =>
                node.id === id
                    ? { ...node, data: { ...node.data, header, body, footer, catalog_id: catalogId, sections } }
                    : node
            )
        );
    }, [header, body, footer, catalogId, sections, id, setNodes]);

    const addSection = () => {
        if (sections.length >= 10) return; // Limit sections
        setSections([...sections, { title: `Section ${sections.length + 1}`, product_items: [{ product_retailer_id: "" }] }]);
    };

    const removeSection = (index) => {
        setSections(sections.filter((_, i) => i !== index));
    };

    const handleSectionTitleChange = (index, value) => {
        const updated = [...sections];
        updated[index].title = value;
        setSections(updated);
    };

    const addProductToSection = (sectionIndex) => {
        const updated = [...sections];
        if (updated[sectionIndex].product_items.length >= 30) return; // Limit products per section
        updated[sectionIndex].product_items.push({ product_retailer_id: "" });
        setSections(updated);
    };

    const removeProductFromSection = (sectionIndex, productIndex) => {
        const updated = [...sections];
        updated[sectionIndex].product_items = updated[sectionIndex].product_items.filter((_, i) => i !== productIndex);
        setSections(updated);
    };

    const handleProductChange = (sectionIndex, productIndex, value) => {
        const updated = [...sections];
        updated[sectionIndex].product_items[productIndex].product_retailer_id = value;
        setSections(updated);
    };

    return (
        <NodeWrapper
            id={id}
            setNodes={setNodes}
            title={
                <h6 className="mb-0">
                    <i className="las la-layer-group"></i> Multi-Product
                </h6>
            }
            content={
                <div style={{ minWidth: "300px" }}>
                    <label className="form-label">Catalog ID <span className="text-danger">*</span></label>
                    <input
                        type="text"
                        className="form-control form--control mb-2"
                        value={catalogId}
                        onChange={(e) => setCatalogId(e.target.value)}
                    />

                    <label className="form-label">Header Text <span className="text-danger">*</span></label>
                    <input
                        type="text"
                        className="form-control form--control mb-2"
                        value={header}
                        onChange={(e) => setHeader(e.target.value)}
                    />

                    <label className="form-label">Body Text <span className="text-danger">*</span></label>
                    <textarea
                        className="form-control form--control mb-2"
                        rows={2}
                        value={body}
                        onChange={(e) => setBody(e.target.value)}
                    />

                    <label className="form-label">Footer Text</label>
                    <input
                        type="text"
                        className="form-control form--control mb-3"
                        value={footer}
                        onChange={(e) => setFooter(e.target.value)}
                    />

                    <hr />
                    <label className="d-block mb-2 font-weight-bold">Sections</label>

                    {sections.map((section, sIndex) => (
                        <div key={sIndex} className="card p-2 mb-2 bg-light">
                            <div className="d-flex justify-content-between mb-2">
                                <input
                                    type="text"
                                    className="form-control form--control form-control-sm"
                                    placeholder="Section Title"
                                    value={section.title}
                                    onChange={(e) => handleSectionTitleChange(sIndex, e.target.value)}
                                />
                                {sections.length > 1 && (
                                    <button className="btn btn-danger btn-sm ms-1" onClick={() => removeSection(sIndex)}>
                                        <i className="las la-trash"></i>
                                    </button>
                                )}
                            </div>

                            {section.product_items.map((item, pIndex) => (
                                <div key={pIndex} className="d-flex gap-1 mb-1">
                                    <input
                                        type="text"
                                        className="form-control form--control form-control-sm"
                                        placeholder="Product Retailer ID"
                                        value={item.product_retailer_id}
                                        onChange={(e) => handleProductChange(sIndex, pIndex, e.target.value)}
                                    />
                                    {section.product_items.length > 1 && (
                                        <button className="btn btn-danger btn-sm" onClick={() => removeProductFromSection(sIndex, pIndex)}>
                                            <i className="las la-times"></i>
                                        </button>
                                    )}
                                </div>
                            ))}

                            <button className="btn btn-outline-primary btn-sm w-100 mt-1" onClick={() => addProductToSection(sIndex)}>
                                <i className="las la-plus"></i> Add Product
                            </button>
                        </div>
                    ))}

                    <button className="btn btn-primary btn-sm w-100 mt-2" onClick={addSection}>
                        <i className="las la-plus-circle"></i> Add Section
                    </button>
                </div>
            }
            handles={handles}
        />
    );
}
